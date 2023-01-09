<?php

namespace App\Http\Controllers;

use App\Scopes\DivisionCenterScope;
use App\Scopes\TeamDivisionCenterScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Holiday;
use App\BloodGroup;
use App\Employee;
use App\Division;
use App\Center;
use App\EventNotice;
use App\HiringRecruitment;
use App\Team;
use DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login','adminLogin']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        // $credentials = request([$this->username(), 'password']);
        // return filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'employer_id';
        $credentials = [
            $this->username() => request('email'),
            'password' => request('password')
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


     /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'employer_id';
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $id = auth('api')->user()->employee_id;
        $employee = Employee::where('id', $id)
            ->withoutGlobalScope(DivisionCenterScope::class)
            ->with(['teamMember' => function($q) {
                return $q->withoutGlobalScope(TeamDivisionCenterScope::class);
            }])->first();
        return response()->json($employee);
    }

    public function nearMe(Request $request)
    {
        $id = auth('api')->user()->employee_id;
        $employee = DB::table('employees')->where('id', $id)->first();
        $employees = Employee::where('nearby_location_id', $employee->nearby_location_id)->whereNotNull('nearby_location_id')->where('id', '!=', $employee->id)->withoutGlobalScopes()->get();
        return response()->json($employees);
    }

    public function holidays(Request $request)
    {
        $this_month = date('m');
        $this_year = date('Y');
        $holidays = Holiday::whereMonth('start_date', '>=', $this_month)->whereYear('start_date', '>=', $this_year)->whereDate('start_date', '>', Carbon::now())->get();
        return response()->json($holidays);
    }

    public function birthdays(Request $request)
    {
        $this_month = date('m');
        $this_year = date('Y');
        $this_date = date('D');
        // $employees = Employee::whereMonth('date_of_birth', '>=', $this_month)->withoutGlobalScopes()->get();
        $employees = Employee::whereRaw('DAYOFYEAR(curdate()) <= DAYOFYEAR(date_of_birth) AND DAYOFYEAR(curdate()) + 14 >=  dayofyear(date_of_birth)')
                    ->orderByRaw('DAYOFYEAR(date_of_birth)')
                    ->withoutGlobalScopes()->get();
        return response()->json($employees);
    }

    public function bloodGroups(Request $request)
    {
        $blood_groups = BloodGroup::all();
        return response()->json($blood_groups);
    }

    public function bloodGroup(Request $request, $id)
    {
        $blood_group_id = $id;
        $employees = Employee::where('blood_group_id', $blood_group_id)->withoutGlobalScopes()->paginate(15);
        return response()->json($employees);
    }

    public function directory(Request $request, $key)
    {
        if($key){
            $employees = Employee::where('first_name', 'LIKE', '%' .$key . '%')->orWhere('last_name', 'LIKE', '%' .$key . '%')->orWhere('employer_id', 'LIKE', $key . '%')->withoutGlobalScopes()->paginate(15);
            // $employees = Employee::where('first_name', 'LIKE', '%' .$key . '%')->orWhere('last_name', 'LIKE', '%' .$key . '%')->orWhere('employer_id', 'LIKE', $key . '%')->when($key, function ($query) use ($key) {
            //     $query->whereHas('employeeJourney', function ($query) use ($key) {
            //         return $query->where('employee_status_id', 1);
            //     });
            // })->withoutGlobalScopes()->paginate(10);
            return response()->json($employees);
        } else {
            $employees = [];
            return response()->json($employees);
        }
    }

    public function employeeInfo(Request $request, $id)
    {
        if($id){
            $departments = [];
            $process = [];
            $centerDivision = [];
            $teams = [];

            $employee = Employee::where('id', $id)->withoutGlobalScopes()->first();
            if($employee){
                foreach($employee->divisionCenters as $item){
                    if($item->division && $item->center){
                        array_push($centerDivision, $item->division->name .',  '.$item->center->center);
                    }
                }
                $designation = $employee->employeeJourney->designation->name;
                foreach($employee->departmentProcess->unique('process_id') as $item){
                    if($item->department){
                        array_push($departments, $item->department->name);
                    }
                    if($item->process && $item->processSegment){
                        array_push($process, $item->process->name .'-'. $item->processSegment->name);
                    }
                }
                $employeeTeams = $employee->teamMember()->withoutGlobalScope(TeamDivisionCenterScope::class)->get();

                if($employeeTeams->count()){
                    foreach($employeeTeams as $team){
                        array_push($teams, $team->name);
                    }
                }
            }
            $data = array(
                'employee' => $employee,
                'departments' => $departments,
                'process' => $process,
                'centerDivision' => $centerDivision,
                'teams' => $teams,
            );
            return response()->json($data);
        } else {
            $employee = [];
            return response()->json($employee);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()->only([
                'id',
                'employee_id',
                'employer_id',
                'email',
                'status',
                'default_division_id',
                'default_center_id',
                'last_login_at',
                'last_login_ip'
                ])
        ]);
    }

    public function removeElement($array,$value) {
        if (($key = array_search($value, $array)) !== false) {
            unset($array[$key]);
        }
        return $array;
    }

    public function noticeBoard()
    {
        $active = 'user-notice-board';
        $calendarDataset = $this->getFilterDataForNoticeEvent();
        return response()->json($calendarDataset);
    }
    
    public function pinnedNoticeBoard()
    {
        $active = 'user-notice-board';
        $calendarDataset = $this->getPinnedDataForNoticeEvent();
        return response()->json($calendarDataset);
    }


    public function eventCalender()
    {
        $active = 'user-event-calender';
        $calendarDataset = $this->getFilterDataForNoticeEvent();
        return response()->json($calendarDataset);
    }

    public function getPinnedDataForNoticeEvent()
    {
        $user_id = auth()->user()->employee_id;
        $division =  0;
        $center = 0;
        $department = (!empty(Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess)) ? Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!empty(Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess)) ? Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!empty(Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess)) ? Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];

        $expOne = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division){
            $q->where('division_id', $division);
            $q->whereIn('center_id', [0]);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->where('is_pinned', 1)->withoutGlobalScopes()->get();

        $expTwo = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->where('is_pinned', 1)->withoutGlobalScopes()->get();

        $expThree = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->where('is_pinned', 1)->withoutGlobalScopes()->get();

        $expFour = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', [0]);
        })->where('is_pinned', 1)->withoutGlobalScopes()->get();

        $expFive = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process, $processSegment){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', $processSegment);
        })->where('is_pinned', 1)->withoutGlobalScopes()->get();

        $expSix = EventNotice::doesnthave('eventNoticeFilter')->where('is_pinned', 1)->withoutGlobalScopes()->get();

        return collect($expOne)->merge($expTwo)->merge($expThree)->merge($expFour)->merge($expFive)->merge($expSix)->sortByDesc('id')->where('status', 1);
    }

    public function getFilterDataForNoticeEvent()
    {
        $user_id = auth()->user()->employee_id;
        $division =  0;
        $center = 0;
        $department = (!empty(Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess)) ? Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!empty(Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess)) ? Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!empty(Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess)) ? Employee::withoutGlobalScopes()->find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];

        $expOne = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division){
            $q->where('division_id', $division);
            $q->whereIn('center_id', [0]);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->withoutGlobalScopes()->get();

        $expTwo = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->withoutGlobalScopes()->get();

        $expThree = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->withoutGlobalScopes()->get();

        $expFour = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', [0]);
        })->withoutGlobalScopes()->get();

        $expFive = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process, $processSegment){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', $processSegment);
        })->withoutGlobalScopes()->get();

        $expSix = EventNotice::doesnthave('eventNoticeFilter')->withoutGlobalScopes()->get();

        return collect($expOne)->merge($expTwo)->merge($expThree)->merge($expFour)->merge($expFive)->merge($expSix)->sortByDesc('id')->where('status', 1);
    }



    public function showNoticeEventUser($id)
    {
        $active = 'notice-board';
        $calendarData = EventNotice::find($id);
        return response()->json($calendarData);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    // public function guard()
    // {
    //     return Auth::guard('api');
    // }

    public function adminLogin()
    {
        $credentials = [
            $this->username() => request('email'),
            'password' => request('password')
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $tokenData = $this->respondWithToken($token);
        // dd($tokenData);
        $assignPermissions = auth('api')->user()->getPermissionNames();
        // return $assignPermissions;

        if ($assignPermissions->isEmpty()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        /* $checkedPermission = $this->checkPermissionsExist($assignPermissions); */

        return response()->json(['data' => $tokenData, 'permission'=> $assignPermissions], 200);
    }



    /* public function checkPermissionsExist($permissionList)
    {

        return [
            'super_admin' => !in_array('Genex Infosys Limited Dhaka Jobs Super Admin View', $permissionList) ? true : false,
            'admin' => !in_array('Genex Infosys Limited Dhaka Jobs Admin View', $permissionList) ? true : false,
            'employer' => !in_array('Genex Infosys Limited Dhaka Jobs Employer View', $permissionList) ? true : false,
        ];


    } */


    public function appDownload() {
        $data = array(
            'android' => "#",
            'ios' => "#",
        );
        return view('auth.app-download', compact('data'));
    }

}
