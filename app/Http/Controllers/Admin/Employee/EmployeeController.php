<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Center;
use App\Division;
use App\EmployeeDivisionCenter;
use App\EmployeeFixedOfficeTime;
use App\Events\EmployeeFixedOfficeTimeEvent;
use App\Events\UserLoginEvent;
use App\Exports\EmployeesExport;
use App\Http\Controllers\Controller;
use App\Imports\EmployeesImport;
use App\LeaveBalanceSetting;
use App\Mail\WelcomeMail;
use App\Rules\MatchOldPassword;
use App\Services\LeaveService;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\Permissions;
use App\Utils\TeamMemberType;
use Cassandra\Date;
use Etc\ManagePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Employee;
use App\User;
use App\BloodGroup;
use App\Process;
use App\ProcessSegment;
use App\Designation;
use App\JobRole;
use App\Department;
use App\EarnLeave;
use App\EmploymentType;
use App\EmployeeStatus;
use Carbon\Carbon;
use App\NearbyLocation;
use App\Education;
use App\EmployeeDepartmentProcess;
use App\Institute;
use App\EmployeeJourney;
use App\Training;
use App\LevelOfEducation;
use App\EmployeeJourneyArchive;
use App\IndividualSalary;
use App\LeaveBalance;
use App\SetLeave;
use App\Roster;
use App\LeaveType;
use App\Scopes\ActiveEmployeeScope;
use App\Scopes\DivisionCenterScope;
use App\Services\EarnLeaveService;
use App\Team;
use Hamcrest\Arrays\IsArray;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;
use function React\Promise\Stream\first;
use Illuminate\Support\Arr;
use Mail;
use PDF;
use Illuminate\Support\Str;
use Excel;


class EmployeeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // employee all ajax for select2
    public function employeeAll(Request $request)
    {
        $keyword = $request->get('keyword');
        $query = Employee::query();
        if (!blank($keyword)) {
            $query
                ->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhere('employer_id', 'like', "%{$keyword}%");

        }
        //$query->orderBy('first_name','asc');
        $query->take(5);
        $result = $query->get()->map(function ($em) {
            return [
                'id' => $em->id,
                'employer_id' => $em->employer_id,
                'name' => $em->employer_id . " - " . $em->first_name . " " . $em->last_name
            ];
        });
        return response()->json($result);
    }

    public function employeeAllByType(Request $request)
    {
        $employeeType = [];
        $user = Auth::user();

        if($user->can(_permission(\App\Utils\Permissions::MANAGE_SALARY_HOURLY_VIEW))){
            array_push($employeeType, EmploymentTypeStatus::HOURLY);
        }

        if($user->can(_permission(\App\Utils\Permissions::MANAGE_SALARY_CONTRACTUAL_VIEW))){
            array_push($employeeType, EmploymentTypeStatus::CONTRACTUAL);
        }

        if($user->can(_permission(\App\Utils\Permissions::MANAGE_SALARY_PERMANENT_VIEW))){
            array_push($employeeType, EmploymentTypeStatus::PROBATION);
            array_push($employeeType, EmploymentTypeStatus::PERMANENT);
        }


        $keyword = $request->get('keyword');
        $query = Employee::query();
        if (!blank($keyword)) {
            $query
                ->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhere('employer_id', 'like', "%{$keyword}%");

        }

        $query->whereHas('employeeJourney', function ($r) use ($employeeType){
            $r->whereIn('employment_type_id', $employeeType);
        })
            ->withoutGlobalScope(ActiveEmployeeScope::class)
            ->take(5);


        $result = $query->get()->map(function ($em) {
            return [
                'id' => $em->id,
                'employer_id' => $em->employer_id,
                'name' => $em->employer_id . " - " . $em->first_name . " " . $em->last_name
            ];
        });
        return response()->json($result);
    }


    // switch division center
    public function switchDivisionCenter(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'center_id' => 'required',
        ]);

        $division = Division::where('id', $request->get('division_id'))->first();
        $center = Center::where('id', $request->get('center_id'))->first();

        // check if user have access to the center division
        $userDivisionCenters = auth()->user()->employeeDetails->divisionCenters;
        if(!$userDivisionCenters->where('division_id', $division->id)->where('center_id', $center->id)->count()){
            toastr()->error("You don't have access for division: " . $division->name . ", center: " . $center->center, "Sorry!");
            return redirect()->back();
        }

        // check if user have permission to the center division
        if(auth()->user()->getAllPermissions()->where('division', $division->name)->where('center', $center->center)->count()){
            $request->session()->put('division', $division->name);
            $request->session()->put('center', $center->center);
            if ($request->get('set_default')) {
                auth()->user()->default_division_id = $request->get('division_id');
                auth()->user()->default_center_id = $request->get('center_id');
                auth()->user()->save();
            }
            toastr()->success('Division: ' . $division->name . ' Center: ' . $center->center);
            return redirect()->back();
        }else{
            toastr()->error("You don't have permission for division: " . $division->name . ", center: " . $center->center, "Sorry!");
            return redirect()->back();
        }


    }

    // employee list view
    public function index(Request $request)
    {
        $active = 'employee';

        // for update profile completion
        // $employees = Employee::withoutGlobalScopes()->chunk(200, function ($employees) {
        //    foreach ($employees as $employee){
        //        $employee->employeeJourney()->update(['employer_id' => $employee->employer_id]);
        //        $employee->employeeJourneyArchive()->update(['employer_id' => $employee->employer_id]);
        //    }
        // });
        //(new LeaveService($employee))->leaveBalanceGenerate(4, $request->input('probation_start_date'), $request->input('permanent_doj'));

        // testing code
        // $employee = Employee::withoutGlobalScope(ActiveEmployeeScope::class)->withoutGlobalScope(DivisionCenterScope::class)->whereId(176)->first();
        // $employee = Employee::withoutGlobalScopes()->whereId(176)->first();
        // $employee = Employee::withoutGlobalScope(ActiveEmployeeScope::class)->withoutGlobalScope(DivisionCenterScope::class)
        //             ->whereHas('employeeJourney', function ($q) {
        //                 $q->where('employee_status_id', 1)
        //                     ->orWhere(function($q){
        //                         $q->where('employee_status_id', 2)->whereMonth('lwd', date('m'));
        //                     });
        //             })
        //             ->with('employeeJourney')
        //             ->get();
        // dd($employee);
        // testing code end
        //$division = Division::where('name', session()->get('division'))->with(['centers'])->first();
        //$center = $division->centers->where('center', session()->get('center'))->first();
        //$employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
        //    ->whereHas('divisionCenters', function ($query) use ($division, $center) {
        //        $query->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
        //    })
        //    ->withoutGlobalScope(DivisionCenterScope::class)
        //    ->withoutInactiveSuspended()
        //    ->orderBy('employer_id', 'asc')
        //    ->with(['employeeJourney.designation',
        //        'employeeJourney.employeeStatus',
        //        'departmentProcess.department',
        //        'departmentProcess.process',
        //        'bloodGroup',
        //        'divisionCenters',
        //        'divisionCenters' => function($q) use ($division, $center) {
        //            $q->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
        //        }
        //    ])->take(10)->get();

        //dd($employees);


        return view('admin.employee.employee-list', compact('active'));
    }

    // employee datatable api
    public function anyData(Request $request)
    {
        //$employees = Employee::select('id', 'login_id', 'employer_id', 'first_name', 'last_name', 'blood_group_id', 'email', 'gender','contact_number', 'profile_image')->with(['employeeJourney.designation', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        $division = Division::where('name', session()->get('division'))->with(['centers'])->first();
        $center = $division->centers->where('center', session()->get('center'))->first();
        if (!empty($request->get('search'))) {
            //$employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
            //    ->where('login_id', 'like', '%' . $request->get('search') . '%')
            //    ->orWhere('employer_id', 'like', '%' . $request->get('search') . '%')
            //    ->orWhere('first_name', 'like', '%' . $request->get('search') . '%')
            //    ->orWhere('last_name', 'like', '%' . $request->get('search') . '%')
            //    ->orWhere(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%" . $request->get('search') . "%")
            //    ->orWhere('email', 'like', '%' . $request->get('search') . '%')
            //    ->orWhere('gender', 'like', '%' . $request->get('search') . '%')
            //    ->orWhere('contact_number', 'like', '%' . $request->get('search') . '%')
            //    ->orWhereHas('employeeJourney.designation', function ($query) use ($request) {
            //        $query->where('name', 'like', '%' . $request->get('search') . '%');
            //    })
            //    ->orWhereHas('departmentProcess.department', function ($query) use ($request) {
            //        $query->where('name', 'like', '%' . $request->get('search') . '%');
            //    })
            //    ->orWhereHas('departmentProcess.process', function ($query) use ($request) {
            //        $query->where('name', 'like', '%' . $request->get('search') . '%');
            //    })
            //    ->orWhereHas('bloodGroup', function ($query) use ($request) {
            //        $query->where('name', 'like', '%' . $request->get('search') . '%');
            //    })
            //    ->whereHas('employeeJourney', function ($query) use ($request) {
            //        $query->where('employee_status_id', 1);
            //    })
            //    ->whereHas('divisionCenters', function ($query)  use ($division, $center) {
            //        $query->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
            //    })
            //    ->withoutInactiveSuspended()
            //    ->withoutGlobalScope(DivisionCenterScope::class)
            //    ->orderBy('employer_id', 'asc')
            //    ->with(['employeeJourney.designation', 'employeeJourney.employeeStatus', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup', 'divisionCenters' => function($q) use ($division, $center) {
            //        $q->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
            //    }]);
            $employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
                ->where(function ($q) use ($request){
                    $q->where('login_id', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('employer_id', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('first_name', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('last_name', 'like', '%' . $request->get('search') . '%')
                        ->orWhere(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%" . $request->get('search') . "%")
                        ->orWhere('email', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('gender', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('contact_number', 'like', '%' . $request->get('search') . '%')
                        ->orWhereHas('employeeJourney.designation', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->get('search') . '%');
                        })
                        ->orWhereHas('departmentProcess.department', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->get('search') . '%');
                        })
                        ->orWhereHas('departmentProcess.process', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->get('search') . '%');
                        })
                        ->orWhereHas('bloodGroup', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->get('search') . '%');
                        });
                })
                ->whereHas('employeeJourney', function ($query) use ($request) {
                    $query->where('employee_status_id', 1);
                })
                ->whereHas('divisionCenters', function ($query)  use ($division, $center) {
                    $query->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
                })
                ->withoutInactiveSuspended()
                ->withoutGlobalScope(DivisionCenterScope::class)
                ->orderBy('employer_id', 'asc')
                ->with(['employeeJourney.designation', 'employeeJourney.employeeStatus', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup', 'divisionCenters' => function($q) use ($division, $center) {
                    $q->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
                }]);
        } else {
            $employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
                ->whereHas('divisionCenters', function ($query) use ($division, $center) {
                    $query->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
                })
                ->withoutGlobalScope(DivisionCenterScope::class)
                ->withoutInactiveSuspended()
                ->orderBy('employer_id', 'asc')
                ->with(['employeeJourney.designation',
                    'employeeJourney.employeeStatus',
                    'departmentProcess.department',
                    'departmentProcess.process',
                    'bloodGroup',
                    'divisionCenters' => function($q) use ($division, $center) {
                        $q->where('is_main', 1)->where('division_id', $division->id)->where('center_id', $center->id);
                    }
                ]);
        }


        return DataTables::of($employees)
            //->addIndexColumn()
            ->addColumn('name', function ($employees) {
                //return '<a href="#" class="kt-media kt-media--sm kt-media--circle" title=""><img src="https://keenthemes.com/metronic/themes/metronic/theme/default/demo1/dist/assets/media/users/100_1.jpg" alt="image"></a>'.' '.$employees->first_name.' '.$employees->last_name;
                $user = [];
                $user['name'] = $employees->first_name . ' ' . $employees->last_name;
                $user['image'] = $employees->profile_image ?? null;
                $user['gender'] = $employees->gender;
                return $user;
            })
            ->addColumn('department', function ($employees) {
                //return optional($employees->employeeJourney->department)->name;
                $data = [];
                if ($employees->departmentProcess) {
                    foreach ($employees->departmentProcess->unique('department_id') as $item) {
                        $data[] = $item->department->name;
                    }
                } else {
                    $data[] = '-';
                }

                return $data;
            })
            ->addColumn('designation', function ($employees) {
                return optional($employees->employeeJourney->designation)->name;
            })
            ->addColumn('process', function ($employees) {
                //return optional($employees->employeeJourney->process)->name;
                $data = [];
                if ($employees->departmentProcess) {
                    foreach ($employees->departmentProcess->unique('process_id') as $item) {
                        $data[] = $item->process->name ?? '-';
                    }
                } else {
                    $data[] = '-';
                }

                return $data;
            })
            ->addColumn('center', function ($employees) {
                //return optional($employees->center)->center;
                //return optional($employees->employeeJourney->process)->name;
                $data = [];
                if ($employees->divisionCenters) {
                    foreach ($employees->divisionCenters as $item) {
                        $data[] = $item->division->name . ' - ' . $item->center->center ?? '-';
                    }
                } else {
                    $data[] = '-';
                }

                return $data;
            })
            ->addColumn('blood_group', function ($employees) {
                return optional($employees->bloodGroup)->name;
            })
            ->addColumn('status', function ($employees) {
                return $employees->employeeJourney->employeeStatus->status;
            })
            ->addColumn('action', function ($employees) {

                $info = '<a href="#" data-employee-id='.$employees->id.' data-toggle="modal" data-target="#employeeState" target="_blank" class="employeeStateIcon"><i class="flaticon-interface-6"></i></a>';
                $view = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_PROFILE_VIEW)) ? '<a href="' . route('employee.profile', ["id" => $employees->id]) . '" target="_blank" class="editor_edit"><i class="flaticon-eye"></i></a>' : null;
                $edit = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_EDIT)) ? '<a target="_blank" href="' . route('employee.update.view', ['id' => $employees->id]) . '" class="editor_edit"><i class="flaticon-edit"></i></a>' : null;
                $role = auth()->user()->hasAllPermissions([_permission(Permissions::ADMIN_ROLE_VIEW), _permission(Permissions::ADMIN_ROLE_CREATE), _permission(Permissions::ADMIN_PERMISSION_VIEW), _permission(Permissions::ADMIN_PERMISSION_CREATE)]) ? '<a target="_blank" href="' . route('employee.permissions.view', ["id" => $employees->id]) . '" class="editor_edit"><i class="la la-user-secret"></i></a>' : null;
                //$delete = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_DELETE)) ? '<a href="#" id="' . $employees->id . '" class="employee_remove"><i class="flaticon-delete"></i></a>' : null;
                $delete = '';
                return $info. ' / ' .$view . (($view && $edit) ? (' / ' . $edit) : $edit) . ' ' . (($view && $edit && $role || $view && $role || $edit && $role) ? (' / ' . $role) : $role) . ' ' . (($view && $edit && $role && $delete || $edit && $role && $delete || $view && $role && $delete || $view && $edit && $delete || $view && $delete || $edit && $delete) ? (' / ' . $delete) : $delete);
                // return '<a href="' . route('employee.profile', ["id" => $employees->id]) . '" target="_blank" class="editor_edit"><i class="flaticon-eye"></i></a> / <a target="_blank" href="'.route('employee.update.view', ['id'=> $employees->id]).'" class="editor_edit"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a>';
            })
            ->smart(false)
            ->make(true);

    }

    public function exportDataView()
    {
        $active = 'export-data';
        $divisions = Division::all();
        $employmentTypes = EmploymentType::all();
        return view('admin.employee.employee-export', compact('active', 'divisions', 'employmentTypes'));
    }


    public function exportData(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'center_id' => 'required',
            'employment_type_id' => 'required',
        ]);

        $employmentType = EmploymentType::find($request->input('employment_type_id'));

        return Excel::download(new EmployeesExport($request), 'EmployeesExport-'.$employmentType->type.'-'.now()->toDateString().'.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function infoState(Request $request){

        $employee = Employee::whereId($request->input('employee_id'))
            ->first();
        $team = $employee->teamMember()->wherePivot('member_type', TeamMemberType::MEMBER)->first();
        $leaveBalance = $employee->leaveBalances->where('year', date('Y'))->where('employment_type_id', $employee->employeeJourney->employment_type_id)->count();
        $leavePermission = (auth()->user()->hasAllPermissions([_permission(Permissions::ADMIN_LEAVE_VIEW)])) ? true : false;
        $salary = $employee->individualSalary;
        $salaryPermission = (auth()->user()->hasAllPermissions([_permission(Permissions::ADMIN_SALARY_VIEW), _permission(Permissions::ADMIN_SALARY_CREATE)])) ? true : false;

        return view('admin.employee.employee-info-modal' ,compact(
            'employee',
            'team',
            'leaveBalance',
            'salary',
            'leavePermission',
            'salaryPermission'
        ));
    }

    // employee list view
    public function inactiveEmployee(Request $request)
    {
        $active = 'employee-inactive';
        return view('admin.employee.employee-inactive-list', compact('active'));
    }

    // employee datatable api
    public function employeeInactiveData(Request $request)
    {
        //$employees = Employee::select('id', 'login_id', 'employer_id', 'first_name', 'last_name', 'blood_group_id', 'email', 'gender','contact_number', 'profile_image')->with(['employeeJourney.designation', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        if (!empty($request->get('search'))) {
            $employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
                ->where('login_id', 'like', '%' . $request->get('search') . '%')
                ->orWhere('employer_id', 'like', '%' . $request->get('search') . '%')
                ->orWhere('first_name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('last_name', 'like', '%' . $request->get('search') . '%')
                ->orWhere(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%" . $request->get('search') . "%")
                ->orWhere('email', 'like', '%' . $request->get('search') . '%')
                ->orWhere('gender', 'like', '%' . $request->get('search') . '%')
                ->orWhere('contact_number', 'like', '%' . $request->get('search') . '%')
                ->orWhereHas('employeeJourney.designation', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('search') . '%');
                })
                ->orWhereHas('departmentProcess.department', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('search') . '%');
                })
                ->orWhereHas('departmentProcess.process', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('search') . '%');
                })
                ->orWhereHas('bloodGroup', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('search') . '%');
                })
                ->inactiveSuspended()
                ->orderBy('employer_id', 'asc')
                ->with(['employeeJourney.designation', 'employeeJourney.employeeStatus', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        } else {
            $employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')->inactiveSuspended()->orderBy('employer_id', 'asc')->with(['employeeJourney.designation', 'employeeJourney.employeeStatus', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        }


        return DataTables::of($employees)
            //->addIndexColumn()
            ->addColumn('name', function ($employees) {
                //return '<a href="#" class="kt-media kt-media--sm kt-media--circle" title=""><img src="https://keenthemes.com/metronic/themes/metronic/theme/default/demo1/dist/assets/media/users/100_1.jpg" alt="image"></a>'.' '.$employees->first_name.' '.$employees->last_name;
                $user = [];
                $user['name'] = $employees->first_name . ' ' . $employees->last_name;
                $user['image'] = $employees->profile_image ?? null;
                $user['gender'] = $employees->gender;
                return $user;
            })
            ->addColumn('department', function ($employees) {
                //return optional($employees->employeeJourney->department)->name;
                $data = [];
                if ($employees->departmentProcess) {
                    foreach ($employees->departmentProcess->unique('department_id') as $item) {
                        $data[] = $item->department->name;
                    }
                } else {
                    $data[] = '-';
                }

                return $data;
            })
            ->addColumn('designation', function ($employees) {
                return optional($employees->employeeJourney->designation)->name;
            })
            ->addColumn('process', function ($employees) {
                //return optional($employees->employeeJourney->process)->name;
                $data = [];
                if ($employees->departmentProcess) {
                    foreach ($employees->departmentProcess->unique('process_id') as $item) {
                        $data[] = $item->process->name ?? '-';
                    }
                } else {
                    $data[] = '-';
                }

                return $data;
            })
            ->addColumn('center', function ($employees) {
                //return optional($employees->center)->center;
                //return optional($employees->employeeJourney->process)->name;
                $data = [];
                if ($employees->divisionCenters) {
                    foreach ($employees->divisionCenters as $item) {
                        $data[] = $item->division->name . ' - ' . $item->center->center ?? '-';
                    }
                } else {
                    $data[] = '-';
                }

                return $data;
            })
            ->addColumn('blood_group', function ($employees) {
                return optional($employees->bloodGroup)->name;
            })
            ->addColumn('status', function ($employees) {
                return $employees->employeeJourney->employeeStatus->status;
            })
            ->addColumn('action', function ($employees) {
                $view = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_PROFILE_VIEW)) ? '<a href="' . route('employee.profile', ["id" => $employees->id]) . '" target="_blank" class="editor_edit"><i class="flaticon-eye"></i></a>' : null;
                $edit = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_EDIT)) ? '<a target="_blank" href="' . route('employee.update.view', ['id' => $employees->id]) . '" class="editor_edit"><i class="flaticon-edit"></i></a>' : null;
                $role = auth()->user()->hasAllPermissions([_permission(Permissions::ADMIN_ROLE_VIEW), _permission(Permissions::ADMIN_ROLE_CREATE), _permission(Permissions::ADMIN_PERMISSION_VIEW), _permission(Permissions::ADMIN_PERMISSION_CREATE)]) ? '<a target="_blank" href="' . route('employee.permissions.view', ["id" => $employees->id]) . '" class="editor_edit"><i class="la la-user-secret"></i></a>' : null;
                $delete = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_DELETE)) ? '<a href="#" id="' . $employees->id . '" class="employee_remove"><i class="flaticon-delete"></i></a>' : null;
                return $view . (($view && $edit) ? (' / ' . $edit) : $edit) . ' ' . (($view && $edit && $role || $view && $role || $edit && $role) ? (' / ' . $role) : $role) . ' ' . (($view && $edit && $role && $delete || $edit && $role && $delete || $view && $role && $delete || $view && $edit && $delete || $view && $delete || $edit && $delete) ? (' / ' . $delete) : $delete);
                // return '<a href="' . route('employee.profile', ["id" => $employees->id]) . '" target="_blank" class="editor_edit"><i class="flaticon-eye"></i></a> / <a target="_blank" href="'.route('employee.update.view', ['id'=> $employees->id]).'" class="editor_edit"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a>';
            })
            ->smart(false)
            ->make(true);

    }

    // employee list view
    public function unTrackedEmployee(Request $request)
    {
        $active = 'unTrackedEmployee';
        return view('admin.employee.untracked-employee-list', compact('active'));
    }

    // employee datatable api
    public function untrackedList(Request $request)
    {
        //$employees = Employee::select('id', 'login_id', 'employer_id', 'first_name', 'last_name', 'blood_group_id', 'email', 'gender','contact_number', 'profile_image')->with(['employeeJourney.designation', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        if (!empty($request->get('search'))) {
            $employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
                ->whereDoesntHave('teamMember', function ($q) use ($request) {

                })
                ->wherehas('employeeJourney', function ($q) use ($request) {
                    $q->where('employee_status_id', 1);
                })
                ->where('employer_id', 'like', '%' . $request->get('search') . '%')
                ->orderBy('employer_id', 'asc')
                ->with(['employeeJourney.designation', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        } else {
            $employees = Employee::select('id', 'login_id', DB::raw('CONVERT(SUBSTRING_INDEX(employer_id,\'-\',-1), UNSIGNED INTEGER) AS employer_id'), 'first_name', 'last_name', 'blood_group_id', 'email', 'gender', 'contact_number', 'profile_image')
                ->whereDoesntHave('teamMember')
                ->whereHas('employeeJourney', function ($q) {
                    $q->where('employee_status_id', 1);
                })
                ->orderBy('employer_id', 'asc')
                ->with(['employeeJourney.designation', 'departmentProcess.department', 'departmentProcess.process', 'bloodGroup']);
        }

        if (!empty($request->get('csv'))) {
            $csvEmployee = $employees->get();
            return (new FastExcel($csvEmployee))->download('untracked-employee.csv');
        } else {
            return DataTables::of($employees)
                //->addIndexColumn()
                ->addColumn('name', function ($employees) {
                    //return '<a href="#" class="kt-media kt-media--sm kt-media--circle" title=""><img src="https://keenthemes.com/metronic/themes/metronic/theme/default/demo1/dist/assets/media/users/100_1.jpg" alt="image"></a>'.' '.$employees->first_name.' '.$employees->last_name;
                    $user = [];
                    $user['name'] = $employees->first_name . ' ' . $employees->last_name;
                    $user['image'] = $employees->profile_image ?? null;
                    $user['gender'] = $employees->gender;
                    return $user;
                })
                ->addColumn('department', function ($employees) {
                    //return optional($employees->employeeJourney->department)->name;
                    $data = [];
                    if ($employees->departmentProcess) {
                        foreach ($employees->departmentProcess->unique('department_id') as $item) {
                            $data[] = $item->department->name;
                        }
                    } else {
                        $data[] = '-';
                    }

                    return $data;
                })
                ->addColumn('designation', function ($employees) {
                    return optional($employees->employeeJourney->designation)->name;
                })
                ->addColumn('process', function ($employees) {
                    //return optional($employees->employeeJourney->process)->name;
                    $data = [];
                    if ($employees->departmentProcess) {
                        foreach ($employees->departmentProcess->unique('process_id') as $item) {
                            $data[] = $item->process->name ?? '-';
                        }
                    } else {
                        $data[] = '-';
                    }

                    return $data;
                })
                ->addColumn('center', function ($employees) {
                    //return optional($employees->center)->center;
                    //return optional($employees->employeeJourney->process)->name;
                    $data = [];
                    if ($employees->divisionCenters) {
                        foreach ($employees->divisionCenters as $item) {
                            $data[] = $item->division->name . ' - ' . $item->center->center ?? '-';
                        }
                    } else {
                        $data[] = '-';
                    }

                    return $data;
                })
                ->addColumn('blood_group', function ($employees) {
                    return optional($employees->bloodGroup)->name;
                })
                ->addColumn('action', function ($employees) {
                    $view = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_PROFILE_VIEW)) ? '<a href="' . route('employee.profile', ["id" => $employees->id]) . '" target="_blank" class="editor_edit"><i class="flaticon-eye"></i></a>' : null;
                    $edit = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_EDIT)) ? '<a target="_blank" href="' . route('employee.update.view', ['id' => $employees->id]) . '" class="editor_edit"><i class="flaticon-edit"></i></a>' : null;
                    $role = auth()->user()->hasAllPermissions([_permission(Permissions::ADMIN_ROLE_VIEW), _permission(Permissions::ADMIN_ROLE_CREATE), _permission(Permissions::ADMIN_PERMISSION_VIEW), _permission(Permissions::ADMIN_PERMISSION_CREATE)]) ? '<a target="_blank" href="' . route('employee.permissions.view', ["id" => $employees->id]) . '" class="editor_edit"><i class="la la-user-secret"></i></a>' : null;
                    $delete = auth()->user()->hasPermissionTo(_permission(Permissions::EMPLOYEE_DELETE)) ? '<a href="#" id="' . $employees->id . '" class="employee_remove"><i class="flaticon-delete"></i></a>' : null;
                    return $view . (($view && $edit) ? (' / ' . $edit) : $edit) . ' ' . (($view && $edit && $role || $view && $role || $edit && $role) ? (' / ' . $role) : $role) . ' ' . (($view && $edit && $role && $delete || $edit && $role && $delete || $view && $role && $delete || $view && $edit && $delete || $view && $delete || $edit && $delete) ? (' / ' . $delete) : $delete);
                    // return '<a href="' . route('employee.profile', ["id" => $employees->id]) . '" target="_blank" class="editor_edit"><i class="flaticon-eye"></i></a> / <a target="_blank" href="'.route('employee.update.view', ['id'=> $employees->id]).'" class="editor_edit"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a>';
                })
                ->smart(false)
                ->make(true);
        }

    }


    // employee profile
    public function employeeProfile($id)
    {
        $active = 'empProfile';
        $employee = Employee::withoutGlobalScopes()->where('id', $id)->with(['employeeJourney', 'employeeJourney.employeeStatus', 'divisionCenters', 'divisionCenters.division', 'divisionCenters.center', 'nearbyLocation', 'bloodGroup', 'userDetails', 'employeeJourney.designation', 'educations', 'educations.levelOfEducation'])->first();
        // dd($employee);
        $roles = Role::all();
        $permissions = Permission::all();
        $divisions = Division::all();
        return view('admin.employee.employee-profile', compact('active', 'employee', 'roles', 'permissions', 'divisions'));
    }

    public function employeeMultiDivisionCenter(Request $request)
    {

        if (EmployeeDivisionCenter::where('employee_id', $request->employee_id)->where('division_id', $request->division_id)->where('center_id', $request->center_id)->exists()) {
            toastr()->error('Already Added.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            return redirect()->back();
        }
        EmployeeDivisionCenter::create($request->all());
        toastr()->success('New Division Center Added.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        return redirect()->back();
    }


    // login access
    public function loginAccess(Request $request)
    {
        if ($user = User::where('employee_id', $request->input('employee_id'))->first()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                toastr()->error('An error has occurred. Password must be Minimum 8 charecters.');
                return redirect()->back()->withInput();
            }
            $user->password = bcrypt($request->input('password'));
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'employer_id' => 'required|unique:users',
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                toastr()->error('An error has occurred. Please try with correct information.');
                return redirect()->back()->withInput();
            }

            $user = new User();
            $user->employee_id = $request->input('employee_id');
            $user->email = $request->input('email');
            $user->employer_id = $request->input('employer_id');
            $user->password = bcrypt($request->input('password'));
            $user->status = EmployeeJourney::where('employee_id', $request->input('employee_id'))->first()->employee_status_id;

        }


        if ($user->save()) {
            //User::find($user->id)->assignRole($request->input('role'));
            User::find($user->id)->assignRole('User');

            // send welcome mail to new employee
            $mailData['name'] = $user->employeeDetails->FullName;
            $mailData['employer_id'] = $request->input('employer_id');
            $mailData['email'] = $request->input('email');
            $mailData['password'] = $request->input('password');
            //Mail::to($mailData['email'])->send(new WelcomeMail($mailData));

            toastr()->success('User credentials successfully created');
        } else {
            toastr()->error('An error has occurred. Please try with correct information.');
        }

        return redirect()->back();

    }

    // user/employee Permissions
    public function userPermission(Request $request)
    {
        $user = User::whereEmployeeId($request->input('employee_id'))->first();
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));
        toastr()->success('User role and permissions updated.');
        return redirect()->back();
    }

    public function employeePermissionsView(Request $request, $id)
    {
        $active = 'empProfile';
        $employee = Employee::find($id);
        $divisions = Division::all();
        //$roles = Role::all();
        //$isSuperAdmin = false;
        //$tempRoles = auth()->user()->getRoleNames();
        //foreach ($tempRoles as $tempRole){
        //    if($tempRole == 'Super Admin')
        //        $isSuperAdmin = true;
        //}
        //$permissions = Permission::where('division', session()->get('division'))->where('center', session()->get('center'))->get()->reduce(function ($permissions, $permission) {
        //    $namePart = preg_split("/\s+(?=\S*+$)/", $permission->name);
        //    $verb = $namePart[1] ?? null;
        //    if ($verb) {
        //        $permissions[$permission->group][$permission->module][$verb]['name'][] = $permission->name;
        //    }
        //    return $permissions;
        //});
        return view('admin.employee.employee-permissions', compact('active', 'employee', 'divisions'));
    }

    public function employeePermissionsDetailsView($employee_id, $division_id, $center_id)
    {

        $active = 'empProfile';
        $employee = Employee::find($employee_id);
        $divisions = Division::all();
        $roles = Role::all();
        $isSuperAdmin = false;
        $tempRoles = auth()->user()->getRoleNames();
        foreach ($tempRoles as $tempRole) {
            if ($tempRole == 'Super Admin')
                $isSuperAdmin = true;
        }
        $division = Division::whereId($division_id)->first();
        $center = Center::whereId($center_id)->first();
        $permissions = Permission::where('division', $division->name)->where('center', $center->center)->get()->reduce(function ($permissions, $permission) {
            $namePart = preg_split("/\s+(?=\S*+$)/", $permission->name);
            $verb = $namePart[1] ?? null;
            if ($verb) {
                $permissions[$permission->group][$permission->module][$verb]['name'][] = $permission->name;
            }
            return $permissions;
        });

        return view('admin.employee.employee-permissions-details', compact('active', 'employee', 'roles', 'permissions', 'isSuperAdmin', 'divisions'));
    }

    public function employeePermissionSubmit(Request $request)
    {
        //dd(User::whereEmployerId(204)->first()->getPermissionNames());
        $permisionList = [];
        if ($request->all_permissions) {
            //foreach ($request->all_permissions as $permission) {
            $permission = explode(',', $request->all_permissions);
            foreach ($permission as $item) {
                $permisionList[] = $item;
            }
            //}
        }
        //dd($permisionList);
        $user = User::whereEmployeeId($request->input('employee_id'))->first();
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($permisionList);
        toastr()->success('User role and permissions assigned.');
        return redirect()->back();
    }

    // sync permission
    public function syncPermission()
    {
        $divisions = Division::all();
        foreach ($divisions as $division) {
            foreach ($division->centers as $center) {
                $permission = new ManagePermission($division->name, $center->center);
                $permission->generatePermission();
            }
        }
        toastr()->success('Permission sync done.');
        return redirect()->back();
    }


    // add new emp view
    public function addNewEmp()
    {
        $active = 'addNewEmp';
        //$locations = NearbyLocation::all()->groupBy('center_id');
        $locations = NearbyLocation::orderBy('nearby', 'asc')->get()->groupBy('center_id');
        $institutes = Institute::all();
        $bloodGroups = BloodGroup::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $designations = Designation::all();
        $jobRoles = JobRole::all();
        $educationLevels = LevelOfEducation::all();
        $departments = Department::all();
        $employmentTypes = EmploymentType::all();
        $employeeStatuses = EmployeeStatus::all();
        $divisions = Division::all();
        //$centers = Center::all();
        $employeeList = DB::table('employees')->select('id', 'first_name', 'last_name')->get();

        return view('admin.employee.add-employee', compact('locations', 'divisions', 'educationLevels', 'institutes', 'bloodGroups', 'active', 'processes', 'processSegments', 'designations', 'jobRoles', 'departments', 'employmentTypes', 'employeeStatuses', 'employeeList'));
    }

    //check employer_id exist
    public function checkEmployerId(Request $request){
        $employer_id = $request->input('employer_id');
        $isExists = Employee::withoutGlobalScopes()
            ->when($request->input('id'), function($q) use ($request){
                $q->where('id', '!=', $request->input('id'));
            })
            ->where(function ($q) use ($employer_id, $request){
                $q->where('employer_id', $employer_id)
                    ->orWhereHas('employeeJourney', function ($q) use ($employer_id){
                        $q->where('employer_id', $employer_id);
                    })
                    ->orWhereHas('employeeJourneyArchive', function ($q) use ($employer_id){
                        $q->where('employer_id', $employer_id);
                    });
            })
            ->exists();
        if($isExists){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));
        }
    }


    // Add new emp create
    public function addNewEmpCreate(Request $request)
    {
        //dd($request->all());
        $is_fixed_officetime = $request->input('is_fixed_officetime') == 'on' ? 1 : 0;
        $request->merge(['is_fixed_officetime' => $is_fixed_officetime]);
        // validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            //'email' => 'required|email|unique:employees',
            //'personal_email' => 'required|email|unique:employees',
            'employer_id' => 'required|unique:employees',
            'division_id' => 'required',
            'center_id' => 'required',
            'designation_id' => 'required',
            'job_role_id' => 'required',
            'employment_type_id' => 'required',
            'employee_status_id' => 'required',
            'doj' => 'required',
            'contract_start_date' => 'required_if:employment_type_id,1,2',
            'probation_start_date' => 'required_if:employment_type_id,3',
            'probation_period' => 'required_with:probation_start_date',
            'permanent_doj' => 'required_if:employment_type_id,4',
            'academic.*.edu_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
            'training.*.training_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }

        $result = DB::transaction(function () use ($request) {
            try {
                // insert data to employee table
                $employees_table = $request->all();
                if (!($employee_id = Employee::create($employees_table)->id)) {
                    return redirect()->back()->withInput();
                }
                // add id of new inserted employee to request
                $request->request->add(['employee_id' => $employee_id]);
                if ($employee_id) {
                    // create auto user login access
                    if ($request->has('user_login_access')) {
                        $user = new User();
                        $user->employee_id = $request->input('employee_id');
                        $user->email = $request->input('email');
                        $user->employer_id = $request->input('employer_id');
                        $user->password = bcrypt('Genex@123'); // default password is 'genex@123'
                        $user->status = $request->input('employee_status_id');
                        if ($user->save()) {
                            User::find($user->id)->assignRole('User');
                            toastr()->success('Automatic user login access has been created.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                        } else {
                            toastr()->error('Automatic user login access not created.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                        }
                    }

                    // create Division Center
                    EmployeeDivisionCenter::create($request->all());

                    // fixed office time
                    if ($request->input('is_fixed_officetime')) {
                        $this->generateFixedOfficeTime($request);
                    }

                    // insert data to employeeJourney table
                    $employeeJourney_table = EmployeeJourney::create($request->all());

                    // insert data to employeeJourneyArchive table
                    if ($employeeJourney_table) {
                        EmployeeJourneyArchive::create($request->all());
                    }

                    // insert data to education table
                    // $academics = [];
                    foreach ($request->input('academic') as $academic) {
                        $educations = new Education();
                        $educations->employee_id = $employee_id;
                        $educations->level_of_education_id = $academic['level_of_education_id'];
                        $educations->institute = $academic['institute'];
                        $educations->exam_degree_title = $academic['exam_degree_title'];
                        $educations->major = $academic['major'];
                        $educations->result = $academic['result'];
                        $educations->passing_year = $academic['passing_year'];
                        //$educations->save();
                        if ($educations->save() && $academic['institute'] != null) {
                            $check_institute = Institute::where('name', $academic['institute'])->first();
                            if (!$check_institute) {
                                Institute::create(['name' => $academic['institute']]);
                            }
                        }
                    }

                    // insert data to training table
                    foreach ($request->input('training') as $training) {
                        $trainings = new Training();
                        $trainings->employee_id = $employee_id;
                        $trainings->training_title = $training['training_title'];
                        $trainings->country = $training['country'];
                        $trainings->topics_covered = $training['topics_covered'];
                        $trainings->training_year = $training['training_year'];
                        $trainings->institute = $training['institute'];
                        $trainings->duration = $training['duration'];
                        $trainings->location = $training['location'];

                        $trainings->save();
                    }


                    // leave balance generate
                    $employeeType = $request->input('employment_type_id');
                    //if ($employeeType == EmploymentTypeStatus::PROBATION || $employeeType == EmploymentTypeStatus::PERMANENT) {
                        $employee = Employee::find($employee_id);
                        if ($employee) {
                            $leaveService = new LeaveService($employee, $request);
                            $leaveService->leaveBalanceGenerate($employeeType, $request->input('probation_start_date'), $request->input('permanent_doj'));
                            //$this->leaveBalanceGenerate($employee_id, $employeeType, $request->input('probation_start_date'), $request->input('permanent_doj'));
                        }
                    //}

                }
                toastr()->success('New employee successfully created', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                return redirect()->route('employee.profile', $employee_id);
            } catch (\Exception $e) {
                toastr()->error($e->getMessage(), '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                return redirect()->back();
            }
        });
        return $result;
    }

    // employee fixed office time
    public function generateFixedOfficeTime($request)
    {
        EmployeeFixedOfficeTime::where('employee_id', $request->get('employee_id'))->delete();
        foreach ($request->get('day') as $key => $day) {
            $roster_start = Carbon::create($request->get('roster_start')[$key]);
            $roster_end = Carbon::create($request->get('roster_end')[$key]);
            $employeeFixedOfficeTime = new EmployeeFixedOfficeTime();
            $employeeFixedOfficeTime->employee_id = $request->get('employee_id');
            $employeeFixedOfficeTime->day = $day;


            if (isset($_POST['is_offday'])) {
                if (is_array($_POST['is_offday'])) {
                    if (in_array($day, $_POST['is_offday'])) {
                        $employeeFixedOfficeTime->roster_start = null;
                        $employeeFixedOfficeTime->roster_end = null;
                        $employeeFixedOfficeTime->is_offday = 1;
                    } else {
                        $employeeFixedOfficeTime->roster_start = $roster_start->toTimeString();
                        $employeeFixedOfficeTime->roster_end = $roster_end->toTimeString();
                        $employeeFixedOfficeTime->is_offday = 0;
                    }
                }
            } else {
                $employeeFixedOfficeTime->roster_start = $roster_start->toTimeString();
                $employeeFixedOfficeTime->roster_end = $roster_end->toTimeString();
                $employeeFixedOfficeTime->is_offday = 0;
            }
            $employeeFixedOfficeTime->save();
        }
    }

    // update Employee data
    public function updateEmpView($id)
    {
        $active = 'updateEmp';
        $employee = Employee::withoutGlobalScopes()->where('id', $id)->with(['divisionCenters' => function($q){
            return $q->where('is_main', 1);
        }, 'employeeJourney'])->first();
        // dd($employee->employeeJourney);

        //$locations = NearbyLocation::orderBy('nearby', 'asc')->get()->groupBy('center_id');
        $divisions = Division::all();
        $centers = ($employee)
                    ? Center::where('division_id', $employee->divisionCenters->first()->division_id)->get()
                    : Center::all();
        $institutes = Institute::all();
        $bloodGroups = BloodGroup::all();
        // $processes = Process::all();
        // $processSegments = ProcessSegment::all();
        $designations = Designation::all();
        $jobRoles = JobRole::all();
        $educationLevels = LevelOfEducation::all();
        $departments = Department::all();
        $employmentTypes = EmploymentType::all();
        $employeeStatuses = EmployeeStatus::all();
        $employeeList = DB::table('employees')->select('id', 'first_name', 'last_name')->get();

        // dd($employee);
        $locations = NearbyLocation::where('center_id', $employee->divisionCenters()->where('is_main', 1)->first()->center_id)->orderBy('nearby', 'asc')->get()->groupBy('center_id');
        $educations = Education::where('employee_id', $employee->id)->get();
        $trainings = Training::where('employee_id', $employee->id)->get();
        // $employeeJourney = EmployeeJourney::where('employee_id', $employee->id)->first();
        $employeeJourney = $employee->employeeJourney;
        // dd($employeeJourney);

        return view('admin.employee.update-employee', compact(
            'employee',
            'educations',
            'trainings',
            'locations',
            'divisions',
            'centers',
            'educationLevels',
            'institutes',
            'bloodGroups',
            'active',
            // 'processes',
            // 'processSegments',
            'designations',
            'jobRoles',
            'departments',
            'employmentTypes',
            'employeeStatuses',
            'employeeList',
            'employeeJourney'
        ));
    }


    // get center
    public function getCenter($id)
    {
        return Center::where('division_id', $id)->get();
    }

    // get department
    public function getDepartment($id)
    {
        return Center::find($id)->departments;
    }

    // get process
    public function getProcess($id)
    {
        return Department::find($id)->processes;
    }

    // get process
    public function getProcessSegment($id)
    {
        return Process::find($id)->processSegments;
    }

    // set default division center
    public function setDefaultDivisionCenter(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'center_id' => 'required',
        ]);

        $division = Division::whereId($request->get('division_id'))->first();
        $center = Center::whereId($request->get('center_id'))->first();

        // check if user have access to the center division
        $userDivisionCenters = auth()->user()->employeeDetails->divisionCenters;
        if (!$userDivisionCenters->where('division_id', $division->id)->where('center_id', $center->id)->count()) {
            toastr()->error("You don't have access for division: " . $division->name . ", center: " . $center->center, "Sorry!");
            return redirect()->back();
        }

        // check if user have permission to the center division
        if (auth()->user()->getAllPermissions()->where('division', $division->name)->where('center', $center->center)->count()) {
            $request->session()->put('division', $division->name);
            $request->session()->put('center', $center->center);

            auth()->user()->default_division_id = $request->get('division_id');
            auth()->user()->default_center_id = $request->get('center_id');
            auth()->user()->save();

            return redirect()->route('dashboard');
        } else {
            toastr()->error("You don't have permission for division: " . $division->name . ", center: " . $center->center, "Sorry!");
            return redirect()->back();
        }
    }

    public function updateEmpSubmit(Request $request)
    {
        $checkEmployee =  Employee::withoutGlobalScopes()->where('id', $request->input('employee_id'))->first();
        if($checkEmployee->employer_id == $request->get('employer_id')){
            $uniqueEmpId = true;
        }else{
            $uniqueEmpId = false;
        }
        if($request->input('employee_status_id') == 1){
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'employer_id' => 'required|unique:employees,employer_id' . ($uniqueEmpId ? ',' . $checkEmployee->id : ''),
                'division_id' => 'required',
                'center_id' => 'required',
                'designation_id' => 'required',
                'job_role_id' => 'required',
                'employment_type_id' => 'required',
                'employee_status_id' => 'required',
                'doj' => 'required',
                'probation_start_date' => 'required_if:employment_type_id,3',
                'probation_period' => 'required_with:probation_start_date',
                'permanent_doj' => 'required_if:employment_type_id,4',
                'academic.*.edu_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
                'training.*.training_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'employer_id' => 'required|unique:employees,employer_id' . ($uniqueEmpId ? ',' . $checkEmployee->id : ''),
                'division_id' => 'required',
                'center_id' => 'required',
                'designation_id' => 'required',
                'job_role_id' => 'required',
                'employment_type_id' => 'required',
                'employee_status_id' => 'required',
                'academic.*.edu_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
                'training.*.training_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
            ]);
        }

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }

        $is_fixed_officetime = $request->input('is_fixed_officetime') == 'on' ? 1 : 0;
        $request->merge(['is_fixed_officetime' => $is_fixed_officetime]);
        $employees_table = $request->all();
        $employee =  Employee::withoutGlobalScopes()->find($request->input('employee_id'));
        if($employee->employeeJourney->employee_status_id == 1 && $request->input('employee_status_id') != 1){
            if($employee->teamLeadCheck->count()){
                foreach ($employee->teamLeadCheck as $team) {
                    toastr()->error($employee->FullName.' is a team lead of '.$team->name.'. Before inactive/suspend remove form lead first.');
                }
                return redirect()->back()->withInput();
            }
        }
        $employee->update($employees_table);
        $employee->userDetails->update(['employer_id' => $request->input('employer_id')]);
        $employee_id = $employee->id;
        $changes = [];
        if ($employee_id) {
            // update data to employeeJourney table
            $employeeJourney_table = EmployeeJourney::whereEmployeeId($request->input('employee_id'))->first();
            if (!$employeeJourney_table) {
                $employeeJourney_table = new EmployeeJourney();
            }
            // update data to employeeJourneyArchive table

            if ($employeeJourney_table) {
                $employeeJourney_table->fill($request->all());
                $changes = $employeeJourney_table->getDirty();
                $employeeJourney_table->save();

                $employee->userDetails()->update(['status' => $employeeJourney_table->employee_status_id]);
                if ($changes) {
                    $changes['employee_id'] = $employee_id;
                    EmployeeJourneyArchive::create($changes);
                }
            }

            // create Division Center
            $divisionCenter = EmployeeDivisionCenter::where('employee_id', $employee_id)->first();
            $divisionCenter->division_id = $request->get('division_id');
            $divisionCenter->center_id = $request->get('center_id');
            $divisionCenter->save();

            // fixed office time
            if ($request->input('is_fixed_officetime')) {
                $this->generateFixedOfficeTime($request);
            }
            // update data to education table
            $educations = Education::where('employee_id', $request->input('employee_id'))->delete();
            foreach ($request->input('academic') as $academic) {
                if (!is_null($academic['exam_degree_title'])) {
                    $educations = new Education();
                    $educations->employee_id = $employee_id;
                    $educations->level_of_education_id = $academic['level_of_education_id'];
                    $educations->institute = $academic['institute'];
                    $educations->exam_degree_title = $academic['exam_degree_title'];
                    $educations->major = $academic['major'];
                    $educations->result = $academic['result'];
                    $educations->passing_year = $academic['passing_year'];
                    if ($educations->save()) {
                        $check_institute = Institute::where('name', $academic['institute'])->first();
                        if (!$check_institute) {
                            Institute::create(['name' => $academic['institute']]);
                        }
                    }
                }
            }
            // update data to training table
            $trainings = Training::where('employee_id', $request->input('employee_id'))->delete();
            foreach ($request->input('training') as $training) {
                if (!is_null($training['training_title'])) {
                    $trainings = new Training();
                    $trainings->employee_id = $employee_id;
                    $trainings->training_title = $training['training_title'];
                    $trainings->country = $training['country'];
                    $trainings->topics_covered = $training['topics_covered'];
                    $trainings->training_year = $training['training_year'];
                    $trainings->institute = $training['institute'];
                    $trainings->duration = $training['duration'];
                    $trainings->location = $training['location'];

                    $trainings->save();
                }
            }

            if($request->input('employee_status_id') == 1){
                $employeeType = $request->input('employment_type_id');
                $leaveBalance = $employee->leaveBalances()->where('employee_id', $employee_id)->where('employment_type_id', $employeeType)->where('year', date('Y'))->get();

                $leaveBalanceExists = $leaveBalance->where('employment_type_id', $employeeType)->count();
                
                if(!$leaveBalanceExists){
                    (new LeaveService($employee, $request))->leaveBalanceGenerate($employeeType, $request->input('probation_start_date'), $request->input('permanent_doj'), false);
                }                        

                if(array_key_exists('probation_start_date', $changes) || array_key_exists('permanent_doj',$changes) || true){
                    if($request->has('probation_start_date') && (Carbon::parse($request->get('probation_start_date'))->format('Y') ==  date('Y'))){
                        (new LeaveService($employee, $request))->leaveBalanceReGenerate($employeeType, $request->input('probation_start_date'), $request->input('permanent_doj'));
                    }elseif ($request->has('permanent_doj') && (Carbon::parse($request->get('permanent_doj'))->format('Y') ==  date('Y'))){
                        (new LeaveService($employee, $request))->leaveBalanceReGenerate($employeeType, $request->input('probation_start_date'), $request->input('permanent_doj'));
                    }
                } if(array_key_exists('employment_type_id', $changes) && $changes['employment_type_id'] == EmploymentTypeStatus::PERMANENT){
                    $leaves = LeaveBalanceSetting::where('employment_type_id', $changes['employment_type_id'])->get();
                    foreach ($leaves as $key => $leave) {
                        if (LeaveStatus::EARNED == $leave->leaveType->id) {
                            $earnLeaveService = new EarnLeaveService($employee);
                            (session()->has('earned_used')) ?
                            $earnLeaveService->generateEarnBalanceYearly($leave, date('Y'), session('earned_used')) :
                            $earnLeaveService->generateEarnBalanceYearly($leave, date('Y'));
    
                        }
                    }                            
                }
            }


            /* check for salary setting start */
            if($request->input('employee_status_id') == 1){
                $employeeType = $request->input('employment_type_id');
                $salarySetting = IndividualSalary::where('employee_id', $employee_id)->first()->type ?? null;
                if($salarySetting != null && in_array($employeeType, [1, 2])){
                    $salarySettingType = $salarySetting + 1;
                    if($salarySettingType != $employeeType){
                        toastr()->info('Salary type and employment type are not same.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                    }
                }
            }

            /* check for salary setting end*/

        }


        toastr()->success('Information successfully updated.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        return redirect()->route('employee.profile', $employee_id);
    }

    // will be remove later
    //public function leaveBalanceGenerate($employee_id, $employeeType, $probationdate, $permanentdate)
    //{
    //    $employee = Employee::find($employee_id);
    //    $leaves = LeaveBalanceSetting::where('employment_type_id', $employeeType)->get();
    //    foreach ($leaves as $key => $leave) {
    //
    //        $leaveBalance = new LeaveBalance();
    //        $leaveBalance->employee_id = $employee_id;
    //        $leaveBalance->year = date("Y");
    //        $leaveBalance->probation_start_date = $probationdate;
    //        $leaveBalance->permanent_doj = $permanentdate;
    //        $leaveBalance->employment_type_id = $employeeType;
    //        $leaveBalance->leave_type_id = $leave->leaveType->id;
    //        $leaveBalance->total = $leave->quantity;
    //        $leaveBalance->remain = $leave->quantity;
    //        $leaveBalance->save();
    //    }
    //}


    /***
     ** @Function name : All list show data.
     * @Param :
     */
    public
    function allList()
    {
        $active = 'employeeall';
        return view('admin/employee/employee-all-list', compact('active'));
    }


    /***
     ** @Function name : Employee json data
     * @Param :
     */
    public
    function employeeJsonData()
    {
        $employees = Employee::with(['employeeJourney.designation', 'employeeJourney.department', 'employeeJourney.process', 'bloodGroup'])->get();
        return json_encode($employees);
    }


    /**
     ** @Function name :
     * @Param :
     * @return void
     *
     */

    public
    function employeeJourney($id)
    {
        $active = 'employee';
        $employee = Employee::whereId($id)->with(['employeeJourneyArchive' => function($q) {
                        return $q->latest();
                    }, 'departmentProcess' => function ($q) {
                        return $q->withTrashed()->latest();
                    }, 'departmentProcess.process',
                    'departmentProcess.processSegment',
                    'departmentProcess.department',
                    'departmentProcess.teams'])->first();
        $journeys = $employee->employeeJourneyArchive;
        $teamJourneys = $employee->departmentProcess;

        return view('admin.employee.employee-journey', compact('active', 'journeys', 'teamJourneys'));
    }


    /**
     ** @Function name :
     * @Param :
     * @return void
     *
     */

    public
    function pr($data)
    {
        echo '<pre>';
        print_r($data);
        exit;
    }


    /**
     * @method:
     * @param :
     * @return void
     *
     */

    public function leaveBalanceSetup($userId, $employeeType, $probationdate, $permanentdate)
    {
        $columnName = EmploymentType::where('id', $employeeType)->first();
        $selectdColumn = strtolower($columnName->type . '_quantity');
        $prepairedBalance = SetLeave::select("name", "$selectdColumn AS quantity")->get();

        //$leaveIndex = ['total_casual_leave', 'total_sick_leave', 'total_earned_leave', 'total_maternity_leave','total_paternity_leave'];

        $balanceData = [];
        foreach ($prepairedBalance as $key => $array) {
            //$balanceData[$leaveIndex[$key]] = $array->quantity;
            $balanceData['total_' . strtolower($array->name) . '_leave'] = $array->quantity;
            $balanceData['remain_' . strtolower($array->name) . '_leave'] = $array->quantity;
        }
        // dd($balanceData);
        $balanceData['year'] = date("Y");
        $balanceData['employee_id'] = $userId;
        $balanceData['employee_type'] = $employeeType;
        $balanceData['probation_start_date'] = $probationdate;
        $balanceData['permanent_doj'] = $permanentdate;

        $where = array('employee_id' => $userId, 'year' => date('Y'));
        $leaveBalanceData = LeaveBalance::firstOrCreate($where, $balanceData);
        if (isset($leaveBalanceData->employee_type)) {
            if ($leaveBalanceData->employee_type != $employeeType) {
                LeaveBalance::updateOrCreate($where, $balanceData);
            }
        }
    }


    public function deleteEmployee($id)
    {
        Employee::find($id)->delete();
        return redirect()->route('employee.list.view');
    }





    // -- Employee bulk upload from csv -- //
    // view
    public function bulkEmployeeUpload()
    {
        $active = 'uploadEmployee';
        $divisions = Division::all();
        return view('admin.employee.upload-employee', compact('active', 'divisions'));
    }

    public function bulkEmployeeUploadSubmit(Request $request){

        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'division_id' => 'required',
            'center_id' => 'required'
        ]);

        $import = new EmployeesImport();
        try {
            $import->import($request->file('file'));

            toastr()->success('Employee data uploaded.');
            return redirect()->back();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                dump($failure->row()); // row that went wrong
                dump($failure->attribute()); // either heading key (if using heading row concern) or column index
                dump($failure->errors()); // Actual error messages from Laravel validator
                dump($failure->values()); // The values of the row that has failed.
            }
        }
    }

    // submit form
    public function bulkEmployeeUploadSubmitBackup(Request $request)
    {
        //$test = (new FastExcel)->sheet(4)->import($request->file('file'));
        //dd($test);
        DB::transaction(function () use ($request) {
            $bloodGroups = BloodGroup::all();
            $designation = Designation::all();
            $jobRoles = JobRole::all();
            $employmentTypes = EmploymentType::all();
            $divisions = Division::all();
            $centers = Center::all();
            $sheet = $request->input('sheet_number');
            //$faker = Faker::create();
            //$departments = Department::all();
            //$processes = Process::all();
            //$processSegments = ProcessSegment::all();
            $employeeTable = [];
            $employeeJourneyTable = [];
            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            //$employeesCollection = (new FastExcel)->sheet(4)->import($request->file('file'), function($line) use ($faker, $bloodGroups, $departments, $processes, $processSegments, $designation, $employeeTable, $employeeJourneyTable){
            $employeesCollection = (new FastExcel)->sheet($sheet)->import($request->file('file'), function ($line) use ($bloodGroups, $designation, $jobRoles, $employmentTypes, $days, $employeeTable, $employeeJourneyTable, $divisions, $centers) {

                //$bloodGroup = (($line['Blood_Group']) == ' ' || ($line['Blood_Group']) == 'NA' || ($line['Blood_Group']) == '-') ? null : $bloodGroups->where('name', $line['Blood_Group'])->first()['id'];
                $designation = (($line['Designation']) == ' ' || ($line['Designation']) == 'NA' || ($line['Designation']) == '-') ? null : $designation->where('name', $line['Designation'])->first()['id'];
                $employmentType = (($line['Employment_Type']) == ' ' || ($line['Employment_Type']) == 'NA' || ($line['Employment_Type']) == '-') ? null : $employmentTypes->where('type', $line['Employment_Type'])->first()['id'];
                $jobRole = (($line['Functional_Designation/Job_Role']) == ' ' || ($line['Functional_Designation/Job_Role']) == 'NA' || ($line['Functional_Designation/Job_Role']) == '-') ? null : $jobRoles->where('name', $line['Functional_Designation/Job_Role'])->first()['id'];
                //$division = (($line['Division']) == ' ' || ($line['Division']) == 'NA' || ($line['Division']) == '-') ? null : $divisions->where('name', $line['Division'])->first()['id'];
                //$center = (($line['Center']) == ' ' || ($line['Center']) == 'NA' || ($line['Center']) == '-') ? null : $centers->where('division_id', $division)->where('center', $line['Center'])->first()['id'];


                //$process = $processes->where('name', $line['Process'])->first()['id'];
                //$processSegment = $processSegments->where('process_id', $process)->where('name', $line['Process_Segment_(LOB)'])->first()['id'];
                //$department = $departments->where('name', $line['Department'])->first()['id'];

                // ========== permanent date logic ======= //
                $probationStartDate = null;
                $probationPeriod = null;
                $permanentDoj = null;
                if ($employmentType == EmploymentTypeStatus::PROBATION) {
                    $probationStartDate = ($line['DOJ'] == ' ' || ($line['DOJ']) == 'NA' || ($line['DOJ']) == '-') ? null : Carbon::parse($line['DOJ'])->format('Y-m-d');
                    $probationPeriod = 6;
                }
                if ($employmentType == EmploymentTypeStatus::PERMANENT) {
                    $permanentDoj = ($line['DOJ'] == ' ' || ($line['DOJ']) == 'NA' || ($line['DOJ']) == '-') ? null : Carbon::parse($line['DOJ'])->format('Y-m-d');
                }
                // ========== end permanent date logic ======= //

                $contractStartDate = null;
                $contractEndDate = null;
                if ($employmentType == EmploymentTypeStatus::HOURLY || $employmentType == EmploymentTypeStatus::CONTRACTUAL) {
                    $contractStartDate = ($line['DOJ'] == ' ' || ($line['DOJ']) == 'NA' || ($line['DOJ']) == '-') ? null : Carbon::parse($line['DOJ'])->format('Y-m-d');
                }


                $employee = Employee::create(
                    [
                        //'login_id' => $line['Login_ID'],
                        //'blood_group_id' => $bloodGroup,
                        'employer_id' => $line['Employee_ID'],
                        'first_name' => $this->split_name($line['Name'])[0],
                        'last_name' => $this->split_name($line['Name'])[1],
                        //'email' => (($line['Email']) == '' || ($line['Email']) == 'NA' || ($line['Email']) == '-') ? null : $line['Email'],
                        //'personal_email' => $faker->unique()->email,
                        //'center_id' => 1,
                        'gender' => (($line['Gender']) == ' ' || ($line['Gender']) == 'NA' || ($line['Gender']) == '-') ? null : ($line['Gender']),
                        //'date_of_birth' => (($line['DOB']) == ' ' || ($line['DOB']) == 'NA' || ($line['DOB']) == '-') ? null : Carbon::parse($line['DOB'])->format('Y-m-d'),
                        //'religion' => $line['Religion'],
                        //'ssc_reg_num' => $line['SSC_Reg_Num'],
                        //'father_name' => $line['Father_Name'],
                        //'mother_name' => $line['Mother_Name'],
                        //'present_address' => $line['Present_Address'],
                        //'permanent_address' => $line['Permanent_Address'],
                        //'contact_number' => (($line['Contact']) == '' || ($line['Contact']) == 'NA' || ($line['Contact']) == '-') ? null : $line['Contact'],
                        //'alt_contact_number' => (($line['Alt_Cont']) == ' ' || ($line['Alt_Cont']) == 'NA' || ($line['Alt_Cont']) == '-') ? null : $line['Alt_Cont'],
                        //'pool_phone_number' => (($line['Pool_Phone']) == '' || ($line['Pool_Phone']) == 'NA' || ($line['Pool_Phone']) == '-' || ($line['Pool_Phone']) == 'Not Eligible') ? null : $line['Pool_Phone'],
                        //'emergency_contact_person' => (($line['Emergency_Contact_Person']) == ' ' || ($line['Emergency_Contact_Person']) == 'NA' || ($line['Emergency_Contact_Person']) == '-') ? null : $line['Emergency_Contact_Person'],
                        //'emergency_contact_person_number' => (($line['Emergency_Number']) == ' ' || ($line['Emergency_Number']) == 'NA' || ($line['Emergency_Number']) == '-') ? null : $line['Emergency_Number'],
                        //'relation_with_employee' => (($line['Rel_with_Employee']) == ' ' || ($line['Rel_with_Employee']) == 'NA' || ($line['Rel_with_Employee']) == '-') ? null : $line['Rel_with_Employee'],
                        //'nid' => $line['NID'],
                        //'passport' => $line['Passport'],
                        //'marital_status' => $line['Marital_Status'],
                        //'spouse_name' => ($line['Spouse_Name'] == ' ' || ($line['Spouse_Name']) == 'NA' || ($line['Spouse_Name']) == '-') ? null : $line['Spouse_Name'],
                        //'spouse_dob' => ($line['Spouse_DOB'] == ' ' || ($line['Spouse_DOB']) == 'NA' || ($line['Spouse_DOB']) == '-') ? null : Carbon::parse($line['Spouse_DOB'])->format('Y-m-d'),
                        //'child1_name' => ($line['Child1_Name'] == ' ' || ($line['Child1_Name']) == 'NA' || ($line['Child1_Name']) == '-') ? null : $line['Child1_Name'],
                        //'child1_dob' => ($line['Child1_DOB'] == ' ' || ($line['Child1_DOB']) == 'NA' || ($line['Child1_DOB']) == '-') ? null : Carbon::parse($line['Child1_DOB'])->format('Y-m-d'),
                        //'child2_name' => ($line['Child2_Name'] == ' ' || ($line['Child2_Name']) == 'NA' || ($line['Child2_Name']) == '-') ? null : $line['Child2_Name'],
                        //'child2_dob' => ($line['Child2_DOB'] == ' ' || ($line['Child2_DOB']) == 'NA' || ($line['Child2_DOB']) == '-') ? null : Carbon::parse($line['Child2_DOB'])->format('Y-m-d'),
                        //'child3_name' => ($line['Child3_Name'] == ' ' || ($line['Child3_Name']) == 'NA' || ($line['Child3_Name']) == '-') ? null : $line['Child3_Name'],
                        //'child3_dob' => ($line['Child3_DOB'] == ' ' || ($line['Child3_DOB']) == 'NA' || ($line['Child3_DOB']) == '-') ? null : Carbon::parse($line['Child3_DOB'])->format('Y-m-d'),

                        // journey table data
                        //'process_id' => $process,
                        //'process_segment_id' => $processSegment,
                        //'designation_id' => $designation,
                        //'department_id' => $department


                    ]);
                // insert employee journey table
                $employee->employeeJourney()->save(new EmployeeJourney([
                    'employer_id' => $line['Employee_ID'],
                    'designation_id' => $designation,
                    'job_role_id' => $jobRole,
                    'employment_type_id' => $employmentType,
                    'employee_status_id' => 1,
                    'is_fixed_officetime' => 0,
                    'doj' => ($line['DOJ'] == ' ' || ($line['DOJ']) == 'NA' || ($line['DOJ']) == '-') ? null : Carbon::parse($line['DOJ'])->format('Y-m-d'),
                    'contract_start_date' => $contractStartDate,
                    'contract_end_date' => $contractEndDate,
                    //'probation_start_date' => $probationStartDate,
                    //'probation_period' => $probationPeriod,
                    //'permanent_doj' => $permanentDoj,
                    //'new_role_doj' => ($line['New_Role_DOJ'] == ' ' || ($line['New_Role_DOJ']) == 'NA' || ($line['New_Role_DOJ']) == '-') ? null : Carbon::parse($line['New_Role_DOJ'])->format('Y-m-d'),
                    //'permanent_doj' => ($line['Permanent_Transfer_DOJ'] == ' ' || ($line['Permanent_Transfer_DOJ']) == 'NA' || ($line['Permanent_Transfer_DOJ']) == '-') ? null : Carbon::parse($line['Permanent_Transfer_DOJ'])->format('Y-m-d'),
                    //'department_id' => $department
                    //'process_segment_id' => $processSegment,
                    //'process_id' => $process,
                ]));
                // insert employee journey archive table
                $employee->employeeJourneyArchive()->save(new EmployeeJourneyArchive([
                    'employer_id' => $line['Employee_ID'],
                    'designation_id' => $designation,
                    'job_role_id' => $jobRole,
                    'employment_type_id' => $employmentType,
                    'employee_status_id' => 1,
                    'is_fixed_officetime' => 0,
                    'doj' => ($line['DOJ'] == ' ' || ($line['DOJ']) == 'NA' || ($line['DOJ']) == '-') ? null : Carbon::parse($line['DOJ'])->format('Y-m-d'),
                    'contract_start_date' => $contractStartDate,
                    'contract_end_date' => $contractEndDate,
                    //'probation_start_date' => $probationStartDate,
                    //'probation_period' => $probationPeriod,
                    //'permanent_doj' => $permanentDoj,
                    //'new_role_doj' => ($line['New_Role_DOJ'] == ' ' || ($line['New_Role_DOJ']) == 'NA' || ($line['New_Role_DOJ']) == '-') ? null : Carbon::parse($line['New_Role_DOJ'])->format('Y-m-d'),
                    //'permanent_doj' => ($line['Permanent_Transfer_DOJ'] == ' ' || ($line['Permanent_Transfer_DOJ']) == 'NA' || ($line['Permanent_Transfer_DOJ']) == '-') ? null : Carbon::parse($line['Permanent_Transfer_DOJ'])->format('Y-m-d'),
                    //'department_id' => $department
                    //'process_segment_id' => $processSegment,
                    //'process_id' => $process,
                ]));

                $employee->divisionCenters()->save(new EmployeeDivisionCenter([
                    //'division_id' => $division,
                    //'center_id' => $center
                    'division_id' => 1,
                    'center_id' => 1
                ]));

                if ($employmentType == EmploymentTypeStatus::PERMANENT || $employmentType == EmploymentTypeStatus::PROBATION) {
                    event(new EmployeeFixedOfficeTimeEvent($employee->id, $days));
                }

                event(new UserLoginEvent(
                    $employee->id,
                    ($line['Employee_ID']),
                    //(($line['Email']) == ' ' || ($line['Email']) == 'NA' || ($line['Email']) == '-') ? null : $line['Email']
                null
                ));


            });

        });
        //return ($employeesCollection->toArray());


        //DB::table('employees')->insert($employeesCollection->toArray());
        toastr()->success('Employee data uploaded.');
        return redirect()->back();
    }

    // uses regex that accepts any word character or hyphen in last name
    function split_name($name)
    {
        $parts = explode(" ", $name);
        if (count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        } else {
            $firstname = $name;
            $lastname = " ";
        }
        return array($firstname, $lastname);
    }

    public function generalReport(Request $request, $paginate, $is_csv = false)
    {

        // dd($request->all());        
        $df = ($request->input('start_date')) ? date_format(date_create($request->input('start_date')), "Y-m-d") : null;
        $dt = ($request->input('end_date')) ? date_format(date_create($request->input('end_date')), "Y-m-d") : null;
        if ($df && $dt) {
            $filterDate = true;
        } else {
            $filterDate = false;
        }
        $departmentRequest = $request->input('department');
        $processRequest = $request->input('process');
        $processSegmentRequest = $request->input('process_segment');
        $employmentTypeRequest = $request->input('employment_type');
        $designationRequest = $request->input('designation');
        $employeeStatusesRequest = $request->input('employee_status');
        $divisionRequest = $request->input('division');
        $centerRequest = $request->input('center');
        $genderRequest = $request->input('gender');
        $bloodGroupRequest = $request->input('blood_group');
        $filter_type = $request->input('filter_type');
        $religionRequest = $request->input('religion');

        // if(!$employeeStatusesRequest){
        //     $employeeStatusesRequest = 1;
        // }

        // dd($employeeStatusesRequest);

        $division_id = Division::where('name', session()->get('division'))->first()->id;
        $center_id = Center::where('center', session()->get('center'))->first()->id;

        $employees = Employee::select('*')

            ->when($departmentRequest, function ($query) use ($departmentRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($departmentRequest) {
                    return $query->where('department_id', $departmentRequest)->where('removed_at', null);
                });
            })
            ->when($processRequest, function ($query) use ($processRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($processRequest) {
                    return $query->where('process_id', $processRequest)->where('removed_at', null);
                });
            })
            ->when($processSegmentRequest, function ($query) use ($processSegmentRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($processSegmentRequest) {
                    return $query->where('process_segment_id', $processSegmentRequest)->where('removed_at', null);
                });
            })
            ->when($employmentTypeRequest, function ($query) use ($employmentTypeRequest) {
                $query->whereHas('employeeJourney', function ($query) use ($employmentTypeRequest) {
                    return $query->where('employment_type_id', $employmentTypeRequest);
                });
            })
            ->when($employeeStatusesRequest, function ($query) use ($employeeStatusesRequest) {
                $query->whereHas('employeeJourney', function ($query) use ($employeeStatusesRequest) {
                    return $query->where('employee_status_id', $employeeStatusesRequest);
                });
            })
            ->when($designationRequest, function ($query) use ($designationRequest) {
                $query->whereHas('employeeJourney', function ($query) use ($designationRequest) {
                    return $query->where('designation_id', $designationRequest);
                });
            })
            ->when($divisionRequest, function ($query) use ($divisionRequest) {
                $query->whereHas('divisionCenters', function ($query) use ($divisionRequest) {
                    return $query->where('division_id', $divisionRequest)->where('is_main',1);
                });
            },function ($q) use( $division_id){
                $q->whereHas('divisionCenters', function ($query) use( $division_id) {
                    return $query->where('division_id', $division_id)->where('is_main',1);
                });
            })
            ->when($centerRequest, function ($query) use ($centerRequest) {
                $query->whereHas('divisionCenters', function ($query) use ($centerRequest) {
                    return $query->where('center_id', $centerRequest)->where('is_main',1);
                });
            },function ($q) use( $division_id, $center_id){
                $q->whereHas('divisionCenters', function ($query) use( $division_id, $center_id) {
                    return $query->where('center_id', $center_id)->where('is_main',1);
                });
            })
            ->when($genderRequest, function ($query) use ($genderRequest) {
                return $query->where('gender', $genderRequest);
            })
            ->when($religionRequest, function ($query) use ($religionRequest) {
                return $query->where('religion', $religionRequest);
            })
            ->when($bloodGroupRequest, function ($query) use ($bloodGroupRequest) {
                return $query->where('blood_group_id', $bloodGroupRequest);
            })
            ->when($filter_type, function ($query) use ($dt, $df, $filter_type) {
                if ($filter_type == 'all') {
                    return $query;
                } else {
                    if ($filter_type == 'new_join') {
                        $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                            return $query->whereBetween('doj', [$df, $dt]);
                        });
                    } else if ($filter_type == 'provision_expiring') {
                        $interval = 6;
                        $df = date('Y-m-d', strtotime('-' . $interval . ' month', strtotime($df)));
                        $dt = date('Y-m-d', strtotime('-' . $interval . ' month', strtotime($dt)));
                        $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                            return $query->whereBetween('doj', [$df, $dt]);
                        });
                    } else if ($filter_type == 'contract_expiring') {
                        $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                            return $query->whereBetween('contract_end_date', [$df, $dt]);
                        });
                    } else if ($filter_type == 'birthday') {
                        // return $query->whereMonth('date_of_birth', [, $dt]);
                    }
                }
            })
            ->with([                
                'teams',
                'teams.teamLead',
                'departmentProcess',
                'departmentProcess.department',
                'departmentProcess.process',
                'departmentProcess.processSegment',
                'employeeJourney',
                'employeeJourney.designation',
                'employeeJourney.employmentType',
                'employeeJourney.employeeStatus',
                'bloodGroup',
                'divisionCenters',
                'divisionCenters.division',
                'divisionCenters.center',
            ]);
        //dd($employees->withoutGlobalScopes()->get());
        if ($is_csv) {
            return $employees->withoutGlobalScopes()->get();
        } else {
            //return $employees->withoutGlobalScopes()->paginate($paginate);
            return $employees->withoutGlobalScopes()->get();
        }
    }

    public function leaveReport(Request $request, $paginate, $is_csv = false)
    {

        //dd($request->all());
        $df = ($request->input('start_date')) ? date_format(date_create($request->input('start_date')), "Y-m-d") : null;
        $dt = ($request->input('end_date')) ? date_format(date_create($request->input('end_date')), "Y-m-d") : null;
        if ($df && $dt) {
            $filterDate = true;
        } else {
            // return null;
            $filterDate = false;
        }
        $departmentRequest = $request->input('department');
        $processRequest = $request->input('process');
        $processSegmentRequest = $request->input('process_segment');
        $employmentTypeRequest = $request->input('employment_type');
        // dd($employmentTypeRequest);
        $designationRequest = $request->input('designation_id');
        $employeeStatusesRequest = $request->input('employee_status');
        $divisionRequest = $request->input('division');
        $centerRequest = $request->input('center');
        $genderRequest = $request->input('gender');
        $bloodGroupRequest = $request->input('blood_group');
        $filter_type = $request->input('filter_type');
        $religionRequest = $request->input('religion');
        $halfdayRequest = $request->input('is_halfday');
        $leaveTypeRequest = $request->input('leave_type');
        $leave_report_type = $request->input('leave_report_type');
        $year = $request->input('year');
        $employee_id = $request->input('employee_id');


        $division_id = Division::where('name', session()->get('division'))->first()->id;
        $center_id = Center::where('center', session()->get('center'))->first()->id;

        $employees = Employee::select('*')

            ->when($employee_id, function ($query) use ($employee_id){
                $query->where('id', $employee_id);
            }, function ($query) use ($departmentRequest, $processRequest, $processSegmentRequest, $employmentTypeRequest, $employeeStatusesRequest, $divisionRequest, $centerRequest, $genderRequest, $religionRequest, $leaveTypeRequest, $halfdayRequest, $bloodGroupRequest, $division_id, $center_id) {
                $query->when($departmentRequest, function ($query) use ($departmentRequest) {
                        $query->whereHas('departmentProcess', function ($query) use ($departmentRequest) {
                            return $query->where('department_id', $departmentRequest)->where('removed_at', null);
                        });
                    })
                    ->when($processRequest, function ($query) use ($processRequest) {
                        $query->whereHas('departmentProcess', function ($query) use ($processRequest) {
                            return $query->where('process_id', $processRequest)->where('removed_at', null);
                        });
                    })
                    ->when($processSegmentRequest, function ($query) use ($processSegmentRequest) {
                        $query->whereHas('departmentProcess', function ($query) use ($processSegmentRequest) {
                            return $query->where('process_segment_id', $processSegmentRequest)->where('removed_at', null);
                        });
                    })
                    ->when($employmentTypeRequest, function ($query) use ($employmentTypeRequest) {
                        $query->whereHas('employeeJourney', function ($query) use ($employmentTypeRequest) {
                            return $query->where('employment_type_id', $employmentTypeRequest);
                        });
                    })
                    ->when($employeeStatusesRequest, function ($query) use ($employeeStatusesRequest) {
                        $query->whereHas('employeeJourney', function ($query) use ($employeeStatusesRequest) {
                            return $query->where('employee_status_id', $employeeStatusesRequest);
                        });
                    })
                    ->when($divisionRequest, function ($query) use ($divisionRequest) {
                        $query->whereHas('divisionCenters', function ($query) use ($divisionRequest) {
                            return $query->where('division_id', $divisionRequest);
                        });
                    },function ($q) use( $division_id){
                        $q->whereHas('divisionCenters', function ($query) use( $division_id) {
                            return $query->where('division_id', $division_id)->where('is_main',1);
                        });
                    })
                    ->when($centerRequest, function ($query) use ($centerRequest) {
                        $query->whereHas('divisionCenters', function ($query) use ($centerRequest) {
                            return $query->where('center_id', $centerRequest);
                        });
                    },function ($q) use( $division_id, $center_id){
                        $q->whereHas('divisionCenters', function ($query) use( $division_id, $center_id) {
                            return $query->where('center_id', $center_id)->where('is_main',1);
                        });
                    })
                    ->when($genderRequest, function ($query) use ($genderRequest) {
                        return $query->where('gender', $genderRequest);
                    })
                    ->when($religionRequest, function ($query) use ($religionRequest) {
                        return $query->where('religion', $religionRequest);
                    })
                    ->when($leaveTypeRequest, function ($query) use ($leaveTypeRequest) {
                        $query->whereHas('leaves', function ($query) use ($leaveTypeRequest) {
                            $query->where('leave_type_id', $leaveTypeRequest);
                        });
                        return $query;
                    })
                    ->when($halfdayRequest, function ($query) use ($halfdayRequest) {
                        $query->whereHas('leaves', function ($query) use ($halfdayRequest) {
                            $query->where('half_day', '1');
                        });
                        return $query;
                    })
                    ->when($bloodGroupRequest, function ($query) use ($bloodGroupRequest) {
                        return $query->where('blood_group_id', $bloodGroupRequest);
                    });
            })
            // ->whereHas('employeeJourney', function ($query) use ($employmentTypeRequest) {
            //     return $query->where('employee_status_id', 1);
            // })
            ->with([
                'divisionCenters', 'divisionCenters.division', 'divisionCenters.center', 'leaveBalances', 'leaveBalances.leaveType', 'employeeJourney', 'employeeJourney.employmentType', 'employeeJourney.designation',
            ]);

         //dd($leave_report_type);

        if($leave_report_type == 'Use'){
            $employees->when($dt, function ($query) use ($dt, $df, $filter_type) {
                $query->whereHas('leaves', function ($query) use ($df, $dt) {
                    $query->whereBetween('start_date', [$df, $dt]);
                });
                // $query->whereHas('leaves', function ($query) use ($df, $dt) {
                //     $query->whereBetween('end_date', [$df, $dt]);
                // });
                return $query;
            });
        }elseif($leave_report_type == 'Balance'){
            $employees->when($year, function ($query) use ($year, $filter_type) {
                $query->whereHas('leaveBalances', function ($query) use ($year) {
                    $query->where('year', $year);
                });
                return $query;
            });
        }
        $leave_types = LeaveType::all();
        $employeeAll = $employees->withoutGlobalScopes()->get()->reduce(function($data, $employee) use ($leave_types){
            foreach($leave_types as $leaveType){
                $leaveCheck = $employee->leaveBalances->reduce(function($data2, $leaveItem) use ($employee, $leaveType){

                    if(($leaveItem->employment_type_id == $employee->employeeJourney->employment_type_id) && ($leaveItem->leave_type_id == $leaveType->id)){
                        $data2 = $leaveItem;
                    }
                    return $data2;
                });                
                if($leaveCheck) {
                    $short_code = $leaveCheck['leave_type_id'];
                    // dd($short_code);
                    // dd(LeaveStatus::EARNED);
                    $earnLeaveService = new EarnLeaveService($employee);
                    if($short_code == LeaveStatus::EARNED) {
                        $leaveData[$short_code]['used'] = str_replace('.0', '', $leaveCheck->used);
                        $leaveData[$short_code]['remain'] = str_replace('.0', '', ($leaveCheck->total + $earnLeaveService->calculateEarnLeaveBalance() - $leaveCheck->used));
                        $leaveData[$short_code]['total'] = str_replace('.0', '', ($leaveCheck->total + $earnLeaveService->calculateEarnLeaveBalance()));
                    } elseif($short_code == LeaveStatus::CASUAL) {
                        $leaveData[$short_code]['used'] = ($leaveCheck) ? $leaveCheck->used : '-';
                        $leaveData[$short_code]['total'] = str_replace('.0', '', $earnLeaveService->proratedCasualLeave());
                        $leaveData[$short_code]['remain'] = str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain());                        
                    } elseif($short_code == LeaveStatus::SICK) {
                        $leaveData[$short_code]['used'] = ($leaveCheck) ? $leaveCheck->used : '-';
                        $leaveData[$short_code]['total'] = str_replace('.0', '', $earnLeaveService->proratedSickLeave());
                        $leaveData[$short_code]['remain'] = str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain());                        
                    } elseif($short_code == LeaveStatus::LWP) {
                        $leaveData[$short_code]['used'] = ($leaveCheck) ? $leaveCheck->used : '-';
                    } else {
                        $leaveData[$short_code]['used'] = ($leaveCheck) ? $leaveCheck->used : '-';
                        $leaveData[$short_code]['remain'] = ($leaveCheck) ? $leaveCheck->remain : '-';
                        $leaveData[$short_code]['total'] = str_replace('.0', '', $leaveCheck->total);
                    }
                }  else {
                    $leaveData[$leaveType->id]['used'] = '-';
                    $leaveData[$leaveType->id]['remain'] = '-';
                    $leaveData[$leaveType->id]['total'] = '-';
                    // dd($leaveType);
                    // dd($leaveCheck);
                }          
                $lastUpdate = $employee->leaveBalances->sortByDesc('updated_at')->first();
            }
            
            $dataSet['employee'] = $employee;
            $dataSet['leaves'] = $leaveData;
            $dataSet['last-update'] = $lastUpdate;
            $data[] = $dataSet;
            return $data;
        });

        // dd($employeeAll);

        if ($is_csv) {
            // return $employees->withoutGlobalScopes()->get();
            return $employeeAll;
        } else {
            // return $employees->withoutGlobalScopes()->get();
            return $employeeAll;
        }
    }

    public function generateSearchString($filters, $departments, $processes, $processSegments, $employmentTypes, $divisions, $centers, $designations, $employeeStatuses, $bloodGroups, $leaveTypes)
    {
        $count = 0;
        $search_string = '';
        array_shift($filters);
        if (isset($filters['page'])) {
            array_pop($filters);
        }
        if (isset($filters['pagination'])) {
            array_pop($filters);
        }
        array_pop($filters);
        foreach ($filters as $key => $filter) {
            $count++;
            if ($filter) {
                $keyVal = str_replace('_', ' ', $key);
                $search_string .= '<span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill">';
                if ($key == 'department') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $departments->where('id', $filter)->first()->name;
                } else if ($key == 'department_id') {
                    $search_string .= '<strong>Department</strong>: ' . $departments->where('id', $filter)->first()->name;
                } else if ($key == 'process') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $processes->where('id', $filter)->first()->name;
                } else if ($key == 'process_id') {
                    $search_string .= '<strong>Process</strong>: ' . $processes->where('id', $filter)->first()->name;
                } else if ($key == 'process_segment') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $processSegments->where('id', $filter)->first()->name;
                } else if ($key == 'employment_type') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $employmentTypes->where('id', $filter)->first()->type;
                } else if ($key == 'division') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $divisions->where('id', $filter)->first()->name;
                } else if ($key == 'center') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $centers->where('id', $filter)->first()->center;
                } else if ($key == 'designation') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $designations->where('id', $filter)->first()->name;
                } else if ($key == 'employee_status') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $employeeStatuses->where('id', $filter)->first()->status;
                } else if ($key == 'blood_group') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $bloodGroups->where('id', $filter)->first()->name;
                } else if ($key == 'leave_type') {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . $leaveTypes->where('id', $filter)->first()->leave_type;
                } else {
                    $search_string .= '<strong>' . ucfirst($keyVal) . '</strong>: ' . str_replace('_', ' ', ucfirst($filter));
                }
                $search_string .= "</span>";
            }
        }
        return $search_string;
    }

    public function getHeadCountStat($request)
    {

        $df = ($request->input('start_date')) ? date_format(date_create($request->input('start_date')), "Y-m-d") : null;
        $dt = ($request->input('end_date')) ? date_format(date_create($request->input('end_date')), "Y-m-d") : null;
        $departments = Department::all();
        $allEmployeeByGender = Employee::select('gender', DB::raw('count(*) as total'))->groupBy('gender')->get();
        $allEmployee = Employee::all();
        $employeeByDepartment = [];

        foreach ($departments as $department) {
            $departmentRequest = $department->id;
            $employeeByDepartment[$department->name] = 0;
            foreach ($allEmployee as $employee) {
                $isInDepartment = $employee->departmentProcess->where('department_id', $departmentRequest)->count();
                if ($isInDepartment) {
                    $employeeByDepartment[$department->name]++;
                }
            }
        }

        $closingEmployee = Employee::select('*')
            ->when($dt, function ($query) use ($dt, $df) {
                $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                    return $query->whereBetween('contract_end_date', [$df, $dt]);
                });
            });
        $closingList = $closingEmployee->get();
        $closingByDepartment = [];
        // dd($closingList);
        foreach ($departments as $department) {
            $departmentRequest = $department->id;
            $closingByDepartment[$department->name] = 0;
            foreach ($closingList as $newJoiner) {
                $isInDepartment = $newJoiner->departmentProcess->where('department_id', $departmentRequest)->count();
                if ($isInDepartment) {
                    $closingByDepartment[$department->name]++;
                }
            }
        }

        // dd($closingByDepartment);

        $newJoiners = Employee::select('*')
            ->when($dt, function ($query) use ($dt, $df) {
                $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                    return $query->whereBetween('doj', [$df, $dt]);
                });
            });
        $newJoinerByDepartment = [];
        $newJoinerList = $newJoiners->get();
        foreach ($departments as $department) {
            $departmentRequest = $department->id;
            $newJoinerByDepartment[$department->name] = 0;
            foreach ($newJoinerList as $newJoiner) {
                $isInDepartment = $newJoiner->departmentProcess->where('department_id', $departmentRequest)->count();
                if ($isInDepartment) {
                    $newJoinerByDepartment[$department->name]++;
                }
            }
        }

        $provision_expiring = Employee::select('*')
            ->when($dt, function ($query) use ($dt, $df) {
                $interval = 6;
                $df = date('Y-m-d', strtotime('-' . $interval . ' month', strtotime($df)));
                $dt = date('Y-m-d', strtotime('-' . $interval . ' month', strtotime($dt)));
                $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                    return $query->whereBetween('doj', [$df, $dt]);
                });
            });
        $provisionExpiringList = $newJoiners->get();
        foreach ($departments as $department) {
            $departmentRequest = $department->id;
            $provisionExpiringByDepartment[$department->name] = 0;
            foreach ($provisionExpiringList as $newJoiner) {
                $isInDepartment = $newJoiner->departmentProcess->where('department_id', $departmentRequest)->count();
                if ($isInDepartment) {
                    $provisionExpiringByDepartment[$department->name]++;
                }
            }
        }

        $contract_expiring = Employee::select('*')
            ->when($dt, function ($query) use ($dt, $df) {
                $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                    return $query->whereBetween('contract_end_date', [$df, $dt]);
                });
            });
        $contractExpiringList = $newJoiners->get();
        foreach ($departments as $department) {
            $departmentRequest = $department->id;
            $contractExpiringByDepartment[$department->name] = 0;
            foreach ($contractExpiringList as $newJoiner) {
                $isInDepartment = $newJoiner->departmentProcess->where('department_id', $departmentRequest)->count();
                if ($isInDepartment) {
                    $contractExpiringByDepartment[$department->name]++;
                }
            }
        }
        $newJoinerByGender = Employee::select('gender', DB::raw('count(*) as total'))
            ->when($dt, function ($query) use ($dt, $df) {
                $query->whereHas('employeeJourney', function ($query) use ($df, $dt) {
                    return $query->whereBetween('doj', [$df, $dt]);
                });
            })->groupBy('gender')->get();
        $provision_expiringByGender = $provision_expiring->select('gender', DB::raw('count(*) as total'))->groupBy('gender')->get();
        $contract_expiringByGender = $contract_expiring->select('gender', DB::raw('count(*) as total'))->groupBy('gender')->get();

        // dd($allEmployeeByGender);

        $statReport = array(
            'employeeByDepartment' => $employeeByDepartment,
            'departments' => $departments,
            'allEmployeeByGender' => $allEmployeeByGender,
            'newJoinerByDepartment' => $newJoinerByDepartment,
            'provisionExpiringByDepartment' => $provisionExpiringByDepartment,
            'contractExpiringByDepartment' => $contractExpiringByDepartment,
            'newJoinerByGender' => $newJoinerByGender,
            'provision_expiringByGender' => $provision_expiringByGender,
            'contract_expiringByGender' => $contract_expiringByGender,
            'closingByDepartment' => $closingByDepartment,
            'allEmployee' => $allEmployee->count(),
        );
        return $statReport;
        dd($statReport);
    }

    public function attendanceReport(Request $request, $paginate, $is_csv = false)
    {

        $df = $request->has('month') ? $request->input('month') : Carbon::now()->format('Y-m-d');
        $dt = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y-m-d');
        $departments = Department::all();
        $processes = Process::all();
        $roster = Roster::all();
        $requestTest = $request->all();
        if (!$requestTest) {
            return view('admin.attendence.employee-attendance', compact('active', 'df', 'dt', 'departments', 'processes', 'roster'));
        }
        $df = date_format(date_create($request->input('datefrom')), "Y-m-d");
        $dt = date_format(date_create($request->input('dateto')), "Y-m-d");
        $departmentRequest = $request->input('department_id');
        $processRequest = $request->input('process_id');
        $shift = $request->input('shift');
        $employee_id = $request->input('employee_id');
        $employees = Employee::select('id', 'first_name', 'last_name', 'employer_id')
            ->whereHas('attendances', function($query) use ($df, $dt){
                return $query->whereBetween('date', array($df, $dt));
            })
            ->when($employee_id, function ($query) use ($employee_id) {
                return $query->where('id', $employee_id);
            })
            ->when($departmentRequest, function ($query) use ($departmentRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($departmentRequest) {
                    return $query->where('department_id', $departmentRequest);
                });
            })
            ->when($processRequest, function ($query) use ($processRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($processRequest) {
                    return $query->where('process_id', $processRequest);
                });
            })
            ->when($shift, function ($query) use ($shift) {
                $query->whereHas('attendances', function ($query) use ($shift) {
                    return $query->whereTime('roster_start', $shift);
                });
            })
            ->with(['attendances' => function ($query) use ($df, $dt, $shift) {
                $query->whereBetween('date', array($df, $dt))
                    ->when($shift, function ($query) use ($shift) {
                        return $query->whereTime('roster_start', $shift);
                    });
            }, 'departmentProcess'])
            ->orderBy('first_name', 'asc');
        
        if($request->input('display_type') == 'All'){
            $employees = $employees->get();
        } else {
            $employees = $employees->paginate($paginate);
        }


        $tableDate = [];
        foreach ($employees as $items) {
            foreach ($items->attendances as $item) {
                $tableDate[$item->date] = $item->date;
            }
        }

        // dd($employees);

        return array($employees, $tableDate);
    }

    public function generateTeamReport($teamID = false, $request = false)
    {
        // dd($teamID);
    }

    public function teamLeaveReportView(Request $request)
    {
        $teamID = $request->teamID;
        $active = 'team-Leave-report';
        $departments = Department::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $teams = Team::all();
        $this->generateTeamReport($teamID, $request);
        return view('admin.leave.team-leave-report', compact('departments', 'processes', 'processSegments', 'teams', 'active'));
    }

    public function reportView(Request $request)
    {
         //dd($request->all());
         $active = 'general-report';
        //$locations = NearbyLocation::all()->groupBy('center_id');
        $locations = NearbyLocation::orderBy('nearby', 'asc')->get()->groupBy('center_id');
        $institutes = Institute::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $divisions = Division::all();
        $centers = Center::all();
        $departments = Department::all();

        if($request->division){
            $centers = Center::where('division_id', $request->division)->get();
        }
        if($request->center){
            $departments = DB::table('center_department')->join('departments', 'departments.id', 'center_department.department_id')->where('center_department.center_id', $request->center)->get();
        }
        if($request->department){
            $processes = DB::table('department_process')->join('processes', 'processes.id', 'department_process.process_id')->where('department_process.department_id', $request->department)->get();
        }
        if($request->process){
            $processSegments = ProcessSegment::where('process_id', $request->process)->get();
        }
        // dd($processes);
        $designations = Designation::all();
        $jobRoles = JobRole::all();
        $educationLevels = LevelOfEducation::all();
        $employmentTypes = EmploymentType::all();
        $employeeStatuses = EmployeeStatus::all();
        // $employeeList = DB::table('employees')->select('id', 'first_name', 'last_name')->get();
        //$employeeList = Employee::select('id', 'first_name', 'last_name', 'religion')->with(['attendances', 'departmentProcess', 'employeeJourney'])->get();
        $bloodGroups = BloodGroup::all();
        $roster = Roster::all();
        $leaveTypes = LeaveType::all();
        // $employee_religions = Employee::all()->groupBy('religion');
        //$employee_religions = $employeeList->groupBy('religion');
        $employee_religions = array_filter(Employee::groupBy('religion')->pluck('religion')->toArray());
        $employees = [];
        $leaves = [];
        $attendance = [];
        $headcount_stat = [];
        $filters = [];
        $tableDate = [];
        $search_string = "";
        $is_stat = false;
        $paginate = 10;
        if($request->pagination){
            $paginate = $request->pagination;
        }
        $genders = array(
            'Male' => 'Male',
            'Female' => 'Female',
        );
        $leaveTypes = DB::table('leave_types')->get();
        if ($request->all()) {
            $filters = $request->all();
        }

        $requestTest = $request->all();
         //dd($employeeList);
        if (!$requestTest) {
            return view('admin.employee.employee-report', compact('active', 'employees', 'tableDate', 'roster', 'attendance', 'centers', 'leaves', 'headcount_stat', 'is_stat', 'leaveTypes', 'search_string', 'genders', 'filters', 'locations', 'institutes', 'bloodGroups', 'processes', 'processSegments', 'designations', 'jobRoles', 'departments', 'employmentTypes', 'employeeStatuses', 'divisions', 'employee_religions'));
        }
        if ($request->report_type == 'leaveReport') {
            $leaves = $this->leaveReport($request, $paginate, false);
            // dd($leaves);
        } else if ($request->report_type == 'attendanceReport') {
            $attendance = $this->attendanceReport($request, $paginate, false)[0];
            $tableDate = $this->attendanceReport($request, $paginate, false)[1];
        } else {
            $employees = $this->generalReport($request, $paginate, false);
        }


        // dd($employees);

        $search_string = $this->generateSearchString($filters, $departments, $processes, $processSegments, $employmentTypes, $divisions, $centers, $designations, $employeeStatuses, $bloodGroups, $leaveTypes);
        if ($request->submit == 'headcountStat') {
            $search_string = '';
            $is_stat = true;
            $employees = [];
            $headcount_stat = $this->getHeadCountStat($request);
            $isPdf = false;
            if ($isPdf) {
                $data = ['headcount_stat' => $headcount_stat];
                $pdf = PDF::loadView('includes.report.headcount-stat', $data);
                $file = 'headcountStat';
                return $pdf->download($file . '.pdf');
            }
        }

        if ($request->is_csv == "true") {
            // dd($request->all());
            if($request->report_type == 'leaveReport'){
                $employeeCSV = $this->leaveReport($request, $paginate, true);
                 //dd($employeeCSV);
                $employeeData = [];
                foreach ($employeeCSV as $leaveData) {
                    $department = [];
                    $process_segment = [];
                    $division_center = [];
                    $employee = $leaveData['employee'];
                    foreach ($employee->departmentProcess->unique('department_id') as $item) {
                        array_push($department, $item->department->name);
                    }
                    $department = implode(', ', $department);

                    foreach($employee->departmentProcess->unique('process_id') as $item){
                        if($item->process){
                            array_push($process_segment, $item->process->name .' - '. $item->processSegment->name);
                        }
                    }
                    $process_segment = implode(', ', $process_segment);

                    foreach($employee->divisionCenters as $item){
                        if($item->division && $item->center){
                            array_push($division_center, $item->division->name .' - '. $item->center->center);
                        }
                    }
                    $division_center = implode(', ', $division_center);

                    $data = array(
                        'Employee ID' => $employee->employer_id,
                        'Name' => $employee->fullName,
                        'Division - Center' => $division_center,
                        'Department' => $department,
                        'Process - Segment' => $process_segment,
                        'Designation' => $employee->employeeJourney->designation->name,
                        'Employee Status' => $employee->employeeJourney->employeeStatus->status ?? ''
                    );

                    $leaveType['1'] = 'CL';
                    $leaveType['2'] = 'SL';
                    $leaveType['3'] = 'AL';
                    $leaveType['4'] = 'ML';
                    $leaveType['5'] = 'PL';
                    $leaveType['6'] = 'LWP';

                    foreach($leaveData['leaves'] as $key => $balance){
                        // dd($leaveData['leaves']);
                        if($key == LeaveStatus::MATERNITY){
                            $key = $leaveType[$key]; 
                            if(is_numeric($balance['remain']) && (float)$balance['remain']%2 == 0){
                                $data[$key.' Remain'] = "Maternity(2)";
                            }elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['remain']) {
                                $data[$key.' Remain'] = "Maternity(1)";
                            } elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['used']) {
                                $data[$key.' Remain'] = "Maternity(0)";
                            } else {
                                $data[$key.' Remain'] = "-";
                            }
                        } elseif($key == LeaveStatus::PATERNITY){
                            $key = $leaveType[$key];
                            if(is_numeric($balance['remain']) && (float)$balance['remain']%2 == 0) {
                                $data[$key.' Remain'] = "Paternity(2)";
                            } elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['remain']) {
                                $data[$key.' Remain'] = "Paternity(1)";
                            } elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['used']) {
                                $data[$key.' Remain'] = "Paternity(0)";
                            } else {
                                $data[$key.' Remain'] = "-";
                            }
                        } elseif($key == LeaveStatus::LWP) {
                            $key = $leaveType[$key];
                            $data[$key.' Used'] = $balance['used'];
                        } else {
                            $key = $leaveType[$key];
                            if($key == LeaveStatus::EARNED){
                                $data['AL Total'] = $balance['total'];
                                $data['AL Used'] = $balance['used'];
                                $data['AL Remain'] = $balance['remain'];
                            } else {
                                $data[$key.' Total'] = $balance['total'];
                                $data[$key.' Used'] = $balance['used'];
                                $data[$key.' Remain'] = $balance['remain'];
                            }
                        }
                    }


                    // dd($data);

                    array_push($employeeData, $data);
                }
                return (new FastExcel($employeeData))->download('employee_leaves.csv');
            } else {
                $employeeCSV = $this->generalReport($request, $paginate, true);
                $employeeData = [];

                foreach ($employeeCSV as $employee) {
                    $department = [];
                    $process_segment = [];
                    $division_center = [];
                    foreach ($employee->departmentProcess->unique('department_id') as $item) {
                        array_push($department, $item->department->name);
                    }
                    $department = implode(', ', $department);

                    foreach($employee->departmentProcess->unique('process_id') as $item){
                        if($item->process){
                            array_push($process_segment, $item->process->name .' - '. $item->processSegment->name);
                        }
                    }
                    $process_segment = implode(', ', $process_segment);

                    foreach($employee->divisionCenters as $item){
                        if($item->division && $item->center){
                            array_push($division_center, $item->division->name .' - '. $item->center->center);
                        }
                    }
                    $division_center = implode(', ', $division_center);
                    // $team_lead = $employee->employeeTeam->team ? $employee->employeeTeam->team->teamLead ? $employee->employeeTeam->team->teamLead->first_name .' '. $employee->employeeTeam->team->teamLead->last_name  : '' : '';
                    $team_lead = '';
                    foreach($employee->teams as $team){
                        if($team->team_lead_id != $employee->id){
                            if($team->teamLead){
                                $team_lead = $team->teamLead->first_name .' '. $team->teamLead->last_name;
                            }
                        }
                    }
                    $supervisior = '';
                    // $supervisior = $employee->employeeTeam->team ? $employee->employeeTeam->team->supOneEmployee ? $employee->employeeTeam->team->supOneEmployee->first_name .' '. $employee->employeeTeam->team->supOneEmployee->last_name  : '' : '';
                    $data = array(
                        'Employee ID' => $employee->employer_id,
                        'Name' => $employee->fullName,
                        'Division - Center' => $division_center,
                        'Department' => $department,
                        'Process - Segment' => $process_segment,
                        'Designation' => $employee->employeeJourney->designation->name,
                        'DOJ' => $employee->employeeJourney->doj,
                        'LWD' => $employee->employeeJourney->lwd,
                        'Employment type' => $employee->employeeJourney->employmentType->type,
                        'Office phone' => $employee->pool_phone_number,
                        'Email' => $employee->email,
                        'Personal phone' => $employee->contact_number,
                        'Personal email' => $employee->personal_email,
                        'Gender' => $employee->gender,
                        'Blood Group' => $employee->bloodGroup->name ?? '',
                        'Religion' => $employee->religion,
                        'Reporting (one)' => $team_lead,
                        'Reporting (two)' => $supervisior,
                        'Account completed (%)' => $employee->profile_completion,
                        'Employee Status' => $employee->employeeJourney->employeeStatus->status ?? ''
                    );
                    array_push($employeeData, $data);
                }
                return (new FastExcel($employeeData))->download('employees.csv');
            }
        }
        //dd($employees);

        return view('admin.employee.employee-report', compact('active', 'employees', 'roster', 'tableDate', 'attendance', 'leaves', 'headcount_stat', 'is_stat', 'leaveTypes', 'search_string', 'genders', 'filters', 'locations', 'institutes', 'bloodGroups', 'processes', 'processSegments', 'designations', 'jobRoles', 'departments', 'employmentTypes', 'employeeStatuses', 'divisions', 'centers', 'employee_religions'));
    }


    // super admin password change
    public function superAdminChangePasswordView()
    {
        $active = null;
        return view('admin.employee.change-password', compact('active'));
    }

    public function superAdminChangePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        toastr()->success('Password updated successfully.');
        return redirect()->route('dashboard');
    }

    public function impersonate($id)
    {
        $user = User::find($id);

        // Guard against administrator impersonate
        Auth::user()->setImpersonating($user->id);
        request()->session()->put('validateRole', 'User');

        return redirect()->back();
    }

    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();
        request()->session()->put('validateRole', 'Admin');
        toastr()->success('Welcome back!');

        return redirect()->back();
    }

}
