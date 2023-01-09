<?php

namespace App\Http\Controllers;

use App\Charts\AdminChart;
use App\Department;
use App\DocSetup;
use App\Document;
use App\DocumentHeaderTemplate;
use App\DocumentTemplate;
use App\Employee;
use App\EmploymentType;
use App\EventNotice;
use App\EmployeeJourney;
use App\FileParser\NdaParser;
use App\Http\Controllers\User\NoticeEventControllers;
use App\Institute;
use App\LevelOfEducation;
use App\Process;
use App\User;
use App\Utils\NoticeAndEvent;
use App\Utils\Permissions;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
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


    public function index()
    {
        $active = 'home';
        return view('home', compact('active'));
    }

    public function dashboard()
    {
        $employee           =   Employee::select('id', 'gender')->with(['employeeJourney', 'employeeJourney.employmentType:id,type', 'departmentProcess:id,employee_id,department_id,process_id,process_segment_id,team_id'])->get();
        // $employee           =   Employee::select('id', 'first_name', 'last_name', 'gender')->with(['employeeJourney', 'employeeJourney.employmentType:id,type', 'departmentProcess:id,employee_id,department_id,process_id,process_segment_id,team_id'])->take(10)->get();
        $month              =   Carbon::now()->format('m');
        $year               =   Carbon::now()->format('Y');
        $total_employee     =   Employee::whereHas('employeeJourney', function($p){
                                    $p->whereNull('lwd');
                                })->count();

        $total_new_joiner   =   Employee::whereHas('employeeJourney', function($p) use($year, $month){
                                    $p->whereYear('doj', $year)->whereMonth('doj', $month);
                                })->count();

        $total_closing      =   Employee::whereHas('employeeJourney', function($p) use($year, $month){
                                    $p->whereYear('lwd', $year)->whereMonth('lwd', $month);
                                })->count();

        $total_process      =   Process::all()->count();

        /* $total_new_joiner   =   EmployeeJourney::whereYear('doj', $year)->whereMonth('doj', $month)->count();
        $total_new_joiner   =   EmployeeJourney::whereYear('doj', $year)->whereMonth('doj', $month)->count();
        $total_closing      =   EmployeeJourney::whereYear('lwd', $year)->whereMonth('lwd', $month)->count();
        $total_process      =   Process::all()->count(); */

        // dd($employee);
        $stat = array(
            'total_employee'    =>  $total_employee,
            'total_new_joiner'  =>  $total_new_joiner,
            'total_closing'     =>  $total_closing,
            'total_process'     =>  $total_process
        );

        $borderColors = [
            "rgba(120, 43, 144, 0.5)",
            "rgba(45, 189, 182, 0.5)",
            "rgba(255, 205, 86, 0.5)",
            "rgba(51,105,232, 0.5)",
            "rgba(244,67,54, 0.5)",
            "rgba(66,66,66, 0.5)",
            "rgba(34,198,246, 0.5)",
            "rgba(46,125,50, 0.5)",
            "rgba(153, 102, 255, 0.5)",
            "rgba(255, 159, 64, 0.5)",
            "rgba(191,54,12, 0.5)",
            "rgba(233,30,99, 0.5)",
            "rgba(205,220,57, 0.5)",
            "rgba(49,27,146, 0.5)"
        ];
        $fillColors = [
            "rgba(120, 43, 144, 0.7)",
            "rgba(45, 189, 182, 0.7)",
            "rgba(255, 205, 86, 0.7)",
            "rgba(51,105,232, 0.7)",
            "rgba(244,67,54, 0.7)",
            "rgba(66,66,66, 0.7)",
            "rgba(34,198,246, 0.7)",
            "rgba(46,125,50, 0.7)",
            "rgba(153, 102, 255, 0.7)",
            "rgba(255, 159, 64, 0.7)",
            "rgba(191,54,12, 0.7)",
            "rgba(233,30,99, 0.7)",
            "rgba(205,220,57, 0.7)",
            "rgba(49,27,146, 0.7)"

        ];



        // monthly attrition
        $monthlyAttritionStatus = new AdminChart();
        $monthlyAttritionStatus->displayAxes(false);
        $monthlyAttritionStatus->labels(['Opening Strength', 'New Joined', 'Employee Left']);
        $monthlyAttritionStatus->dataset('Monthly Attrition', 'pie', [$total_employee+$total_closing, $total_new_joiner, $total_closing])
            ->color($borderColors)
            ->backgroundcolor($fillColors);


        // gender ratio
        $genderData = $employee
            ->groupBy('gender')
            ->map(function ($item) {
                // Return the number of persons with gender
                return count($item);
            });

        $genderRatio = new AdminChart();
        $genderRatio->displayAxes(false);
        $genderRatio->labels($genderData->keys());
        $genderRatio->dataset('Gender', 'pie', $genderData->values())->color($borderColors)->backgroundcolor($fillColors);


        // employment type
        $employmentTypeData = [];

        foreach (EmploymentType::all() as $empType) {
            $employmentTypeData[$empType->type] = 0;
        }

        if(count($employee)){
            foreach ($employee as $item) {
                (!empty($item->employeeJourney->employmentType)) ? $employmentTypeData[$item->employeeJourney->employmentType->type] = $employmentTypeData[$item->employeeJourney->employmentType->type] + 1 : null;
            }
            $employmentType = new AdminChart();
            $employmentType->displayAxes(false);
            $employmentType->labels(array_keys($employmentTypeData));
            // $employmentType->dataset(implode(array_keys($employmentTypeData), ','), 'pie', array_values($employmentTypeData))->color($borderColors)->backgroundcolor($fillColors);
            $employmentType->dataset('Department wise head count', 'pie', array_values($employmentTypeData))->color($borderColors)->backgroundcolor($fillColors);
        } else {
            $employmentType = new AdminChart();
        }




        // Department wise head count
        $departments = Department::all();
        $employeeByDepartment = [];

        foreach($departments as $department){
            $departmentRequest = $department->id;
            $employeeByDepartment[$department->name] = 0;
            foreach($employee as $emp){
                $isInDepartment = $emp->departmentProcess->where('department_id', $departmentRequest)->count();
                if($isInDepartment){
                    $employeeByDepartment[$department->name]++;
                }
            }
        }

        $departmentHeadCount = new AdminChart();
        //$employmentType->displayAxes(false);
        $departmentHeadCount->labels(array_keys($employeeByDepartment));
        $departmentHeadCount->dataset('Department wise head count', 'bar', array_values($employeeByDepartment))->color($borderColors)->backgroundcolor($fillColors);



        // new joiner

        // $newJoiners = Employee::select('id', 'first_name', 'last_name')
        // $newJoiners = Employee::select('id')
        //     ->when($month, function ($query) use ($year, $month) {
        //         $query->whereHas('employeeJourney', function ($query) use ($year, $month) {
        //             return $query->whereYear('doj', $year)->whereMonth('doj', $month);
        //         });
        //     })
        //     ->with('departmentProcess:id,employee_id,department_id');

        $newJoinersTest = $employee->reduce(function($data, $item) use ($year, $month){
            if($item->employeeJourney && $item->employeeJourney->doj != null && Carbon::parse($item->employeeJourney->doj)->format('Y-m') == Carbon::create($year, $month)->format('Y-m')){
                $data[] = $item;
            }
            return $data;
        });
        $newJoinerByDepartment = [];
        // $newJoinerList = $newJoiners->get();
        $newJoinerList = $newJoinersTest ?? [];
        foreach($departments as $department){
            $departmentRequest = $department->id;
            $newJoinerByDepartment[$department->name] = 0;
            foreach($newJoinerList as $newJoiner){
                $isInDepartment = $newJoiner->departmentProcess->where('department_id', $departmentRequest)->count();
                if($isInDepartment){
                    $newJoinerByDepartment[$department->name]++;
                }
            }
        }

        /* Notice Event */
        $calendarDataset =  (new NoticeEventControllers)->getFilterDataForNoticeEvent()->filter(function ($item){
            return $item->status === NoticeAndEvent::SHOWSTATUS['PUBLISH'];
        })->sortByDesc('id')->take(5);
        /* Notice Event */

        $newJoinerByDepartmentChart = new AdminChart();
        $newJoinerByDepartmentChart->labels(array_keys($newJoinerByDepartment));
        $newJoinerByDepartmentChart->dataset('New Joiner', 'bar', array_values($newJoinerByDepartment))->color($borderColors)->backgroundcolor($fillColors);

        return view('admin.dashboard', compact('monthlyAttritionStatus', 'genderRatio', 'employmentType', 'departmentHeadCount', 'newJoinerByDepartmentChart', 'calendarDataset', 'stat'));
    }


    // force password change
    public function forcePasswordChange()
    {
        return view('auth.passwords.change');
    }

    public function forcePasswordChangeSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);
        auth()->user()->password = bcrypt($request->input('password'));
        auth()->user()->must_change_password = true;
        auth()->user()->save();
        toastr()->success('Password successfully updated.');

        return redirect('/');
    }


    public function checkoutNda()
    {
        $userInfo = auth()->user()->employeeDetails;
        return view('user.nda.check-info', compact('userInfo'));
    }

    public function ndaUpdate(Request $request)
    {
        $userInfo = auth()->user()->employeeDetails;
        $userInfo->father_name = $request->father_name;
        $userInfo->mother_name = $request->mother_name;
        $userInfo->contact_number = $request->mobile;
        $userInfo->nid = $request->nid_or_passport;
        $userInfo->save();

        return redirect()->route('show.info.doc.nda');

    }

    public function showDocNda()
    {
        $userInfo = auth()->user()->employeeDetails;
        $docId = DocSetup::where('name', 'HRMS NDA')->first()->id ?? '';
        $docTemplate = DocumentTemplate::where('type_id', $docId)->first()->content ?? '';

        $result = str_replace(
            [
                'EmployerId',
                'FullName',
                'FatherName',
                'MotherName',
                'MobileNumber',
                'NIDNumber',
                'CurrentDate',
                'OfficeContractNumber',
                'DesignationName'
            ],

            [
                $userInfo->employer_id,
                $userInfo->FullName,
                $userInfo->father_name,
                $userInfo->mother_name,
                $userInfo->contact_number,
                $userInfo->nid,
                date("d M Y"),
                $userInfo->pool_phone_number,
                auth()->user()->employeeDetails->employeeJourney->designation->name
            ],

            $docTemplate
        );

        return view('user.nda.doc-nda', compact('result'));
    }


    public function storeDocNda(Request $request)
    {
        $document = new Document;
        $data = [
            'ref_id' => '',
            'year' => Carbon::now()->year,
            'doc_type_id' => DocSetup::where('name', 'HRMS NDA')->first()->id ?? '',
            'employee_id' => auth()->user()->employee_id,
            'content' => $request->document,
            'status' => 1,
            'document_header_id' => 1, // Default Header set.
            'created_by' => auth()->user()->employee_id
        ];
        $document->create($data);

        $user = auth()->user();
        $user->hrms_nda_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect()->route('user.dashboard');
        }

    // find institute
    public function findInstitute(Request $request){
        $data = Institute::select("name")
            ->where("name","LIKE","%{$request->input('query')}%")
            ->get();

        return response()->json($data);

    }
}
