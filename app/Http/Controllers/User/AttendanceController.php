<?php

namespace App\Http\Controllers\User;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;
use App\Attendance;
use App\AttendanceChangeRequest;
use App\EmployeeFixedOfficeTime;
use App\Leave;
use App\EmployeeHours;
use App\Utils\AttendanceChangeStatus;
use App\Utils\AttendanceStatus;
use App\Utils\LeaveStatus;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Calendar;
use Validator;
use App\Utils\EmploymentTypeStatus;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->baseURL = 'https://my.genexinfosys.com';
    }

    // ajax request for roster details
    public function rosterDetails(Request $request)
    {
        $roster = Attendance::find($request->input('attendance_id'));
        $change_request = $request->get('change_request');

        return view('user.attendance.roster-modal-details', compact('roster', 'change_request'));
    }


    // ajax request for attendance details
    public function attendanceDetails(Request $request)
    {
        $attendance = Attendance::find($request->input('attendance_id'));
        $overTime = 'No overtime.';
        $change_request = $request->get('change_request');
        if ($attendance->punch_in && $attendance->punch_out) {
            $workMinutes = Carbon::create($attendance->punch_in)->diffInMinutes(Carbon::create($attendance->punch_out));
            $workHours = intdiv($workMinutes, 60) . ':' . ($workMinutes % 60);
            if ($workMinutes > 480) {
                $workMinutes = $workMinutes - 480;
                $overTime = intdiv($workMinutes, 60) . ':' . ($workMinutes % 60);
            } else {
                $overTime = 'No overtime.';
            }
        } else {
            $workHours = 'Missing ';
        }

        // if($attendance->punch_in && $attendance->punch_out){
        //     $workMinutes = Carbon::create($attendance->punch_in)->diffInMinutes(Carbon::create($attendance->punch_out));
        //     if($workMinutes > 480){
        //         $workMinutes = $workMinutes-480;
        //         $overTime = intdiv($workMinutes, 60).':'. ($workMinutes % 60);
        //     }else{
        //         $overTime = 'No overtime.';
        //     }

        // }else{
        //     $overTime = 'PunchIn or PunchOut data missing.';
        // }

        return view('user.attendance.attendance-modal-details', compact('attendance', 'workHours', 'overTime', 'change_request'));
    }


    // team member's attendance
    public function teamAttendance(Request $request)
    {

        $active = 'team-attendance';
        //$teams = Team::where('team_lead_id', \Auth::user()->employee_id)->first();
        //foreach($teams->employees as $item){
        //    $team_member_ids[] = $item->id;
        //}
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->month;
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->year;
        $teams = Employee::find(\Auth::user()->employee_id)->teamMember()->having('pivot_member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();
        $employees = collect();
        foreach ($teams as $team) {
            foreach ($team->employees as $item) {
                $employees->push($item);
                $team_member_ids[] = $item->id;
            }
        }

        $start_date = $request->has('date_from');
        $end_date = $request->has('date_to');
        //dd($employees);
        $attendances = null;
        return view('user.attendance.team-attendance', compact('active', 'attendances', 'start_date', 'end_date', 'teams', 'employees'));
    }

    public function teamAttendanceSubmit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'team' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        $active = 'team-attendance';
        $teams = Team::where('id', $request->get('team'))->get();
        $employees = collect();
        foreach ($teams as $team) {
            foreach ($team->employees as $item) {
                $employees->push($item);
                $team_member_ids[] = $item->id;
            }
        }
        $start_date = $request->get('date_from');
        $end_date = $request->get('date_to');
        if ($request->employee_id) {
            $attendances = Attendance::where('employee_id', $request->get('employee_id'))->whereBetween('date', [$start_date, $end_date])->with('employee')->get();
        } else {
            $attendances = Attendance::whereIn('employee_id', $team_member_ids)->whereBetween('date', [$start_date, $end_date])->with('employee')->get();
        }

        return view('user.attendance.team-attendance', compact('active', 'attendances', 'start_date', 'end_date', 'teams', 'employees'));
    }

    // team member's now at office
    public function teamAttendanceNowAtOffice(Request $request)
    {

        $active = 'team-now-at-office';
        //$teams = Team::where('team_lead_id', \Auth::user()->employee_id)->first();
        //foreach($teams->employees as $item){
        //    $team_member_ids[] = $item->id;
        //}
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->month;
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->year;
        $teams = Employee::find(\Auth::user()->employee_id)->teamMember()->get();
        $employees = collect();
        foreach ($teams as $team) {
            foreach ($team->employees as $item) {
                $employees->push($item);
                $team_member_ids[] = $item->id;
            }
        }

        $start_date = $request->has('date_from');
        $end_date = $request->has('date_to');
        //dd($employees);
        $attendances = null;
        return view('user.attendance.team-now-at-office', compact('active', 'attendances', 'start_date', 'end_date', 'teams', 'employees'));
    }

    public function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    public function teamAttendanceNowAtOfficeSubmit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'team' => 'required'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        $report_data = [];
        $active = 'team-now-at-office';
        $teams = Employee::find(\Auth::user()->employee_id)->teamMember()->get();
        $selected_team = Team::where('id', $request->get('team'))->get();
        $employees = collect();
        foreach ($selected_team as $team) {
            foreach ($team->employees as $item) {
                $employees->push($item);
                $team_member_ids[] = $item->id;
            }
        }
        
        $date = date('Y-m-d');   
        $day = date('l');
        $attendance = $this->callApi("GET", $this->baseURL."/api.php?dailyAttendanceLive=true&date=".$date, NULL);
        $attendance = json_decode($attendance);
        if(isset($attendance->data)){
            $attendance = $attendance->data;
        } else {
            $attendance = [];
        }
        $total_attended = [];

        if(isset($attendance)){    
            foreach($attendance as $attendance_data){
                array_push($total_attended, $attendance_data->employee_hrms_id);
            }
            foreach($attendance as $attendance_data){
                if($attendance_data->employee_hrms_id && in_array($attendance_data->employee_hrms_id, $team_member_ids)){
                    $employee_id = $attendance_data->employee_hrms_id;
                    $employee = Employee::withoutGlobalScopes()->where('id', $attendance_data->employee_hrms_id)->first();
                    $punch_in = $attendance_data->punch_in;
                    $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();                
                    $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee_id)->first(); 
                    $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();
                    
                    if($fixedRoster) {                    
                        
                        $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                        $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));
                        if ($punch_in) {
                            if ($fixedRoster->is_offday == 1) {
                                $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                            } else {
                                $roster_entry_time = strtotime($startTime);
                                $punch_in_time = strtotime($punch_in);
                                $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                                
                                $status = AttendanceStatus::PRESENT;
                                if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                    $status = $leaveCheck->leave_type_id;
                                } else if(Carbon::parse($startTime)->format('H:i:s') && $late > 30){
                                    $status = AttendanceStatus::LATE;
                                } else if($late > 10) {
                                    $status = AttendanceStatus::LATE;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') > 7.5){
                                    $status = AttendanceStatus::PRESENT;
                                } else {
                                    $status = AttendanceStatus::PRESENT;
                                }
                            }
                        } else {                            
                            if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                $status = $leaveCheck->leave_type_id;
                            } else if ($fixedRoster->is_offday == 1){
                                $status = AttendanceStatus::DAYOFF;
                            } else {
                                $status = AttendanceStatus::ABSENT;
                            }
                        }                        
                        $attendance_info = array(
                            'date' => $date,
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'punch_in' => $attendance_data->punch_in,
                            'first_checkin' => $attendance_data->first_checkin,
                            'employee_id' => $attendance_data->employee_hrms_id,
                            'employer_id' => $employee->employer_id,
                            'name' => $attendance_data->name,
                            'location' => $attendance_data->first_checkin,
                            'status' => $status,
                        );
                        array_push($report_data, $attendance_info);
                    } else {
                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else {
                            $status = AttendanceStatus::PRESENT;
                        }
                        $startTime = 'No roster';
                        $bendTime = 'No roster';

                        $dataArray = array(
                            'date' => $date,
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'punch_in' => '',
                            'first_checkin' => '',
                            'employee_id' => $employee->id,
                            'employer_id' => $employee->employer_id,
                            'name' => $employee->first_name ." ". $employee->last_name,
                            'location' => $attendance_data->first_checkin,
                            'status' => $status,
                        );
                        array_push($report_data, $dataArray);
                    }
                }
            }  
            foreach($team_member_ids as $team_member){

                if(!in_array($team_member, $total_attended)){
                    $employee_id = $team_member;
                    $punch_in = '';
                    $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();                
                    $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee_id)->first(); 
                    $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();                

                    if($fixedRoster){
                        $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                        $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));

                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else if ($fixedRoster->is_offday == 1){
                            $status = AttendanceStatus::DAYOFF;
                        } else {
                            $status = AttendanceStatus::ABSENT;
                        }
                    } else {
                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else {
                            $status = AttendanceStatus::ABSENT;
                        }
                        $startTime = 'No roster';
                        $bendTime = 'No roster';
                    }
                    $employee = Employee::withoutGlobalScopes()->where('id', $team_member)->first();

                    $dataArray = array(
                        'date' => $date,
                        'roster_start' => $startTime,
                        'roster_end' => $bendTime,
                        'punch_in' => '',
                        'first_checkin' => '',
                        'employee_id' => $employee->id,
                        'employer_id' => $employee->employer_id,
                        'name' => $employee->first_name ." ". $employee->last_name,
                        'location' => null,
                        'status' => $status,
                    );
                    array_push($report_data, $dataArray);
                }
            }          
        } else {
            foreach($team_member_ids as $team_member){
                $employee_id = $team_member;
                $punch_in = '';
                $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();                
                $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee_id)->first(); 
                $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();

                if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                    $status = $leaveCheck->leave_type_id;
                } else if ($fixedRoster->is_offday == 1){
                    $status = AttendanceStatus::DAYOFF;
                } else {
                    $status = AttendanceStatus::ABSENT;
                }

                if($fixedRoster){
                    $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                    $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));

                    if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                        $status = $leaveCheck->leave_type_id;
                    } else if ($fixedRoster->is_offday == 1){
                        $status = AttendanceStatus::DAYOFF;
                    } else {
                        $status = AttendanceStatus::ABSENT;
                    }
                } else {
                    if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                        $status = $leaveCheck->leave_type_id;
                    } else {
                        $status = AttendanceStatus::ABSENT;
                    }
                    $startTime = 'No roster';
                    $bendTime = 'No roster';
                }
                
                $employee = Employee::withoutGlobalScopes()->where('id', $team_member)->first();

                $dataArray = array(
                    'date' => $date,
                    'roster_start' => $startTime,
                    'roster_end' => $bendTime,
                    'punch_in' => '',
                    'first_checkin' => '',
                    'employee_id' => $employee->id,
                    'employer_id' => $employee->employer_id,
                    'name' => $employee->first_name ." ". $employee->last_name,
                    'status' => $status,
                );
                array_push($report_data, $dataArray);
            }
        }
        
        // dd($report_data);
        
        $attendances = [];

        return view('user.attendance.team-now-at-office', compact('active', 'attendances', 'teams', 'selected_team', 'employees', 'report_data'));
    }

    // user attendance
    public function userAttendance(Request $request)
    {
        $active = 'user-attendance';
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->month;
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->year;
        $attendances = Attendance::where('employee_id', \Auth::user()->employee_id)->whereMonth('date', '=', $month)->whereYear('date', '=', $year)->with('employee')->get();
        // $approvedLeaves = Leave::where('leave_status', LeaveStatus::APPROVED)->whereYear('start_date', $year)->whereMonth('start_date', $month)->count();

        // $events = [];
        // if ($attendances->count()) {
        //     foreach ($attendances as $key => $value) {
        //         if ($value->status != AttendanceStatus::DAYOFF && $value->roster_start && $value->roster_end) {
        //             $color = '#4CAF50';
        //         } elseif ($value->status == AttendanceStatus::DAYOFF) {
        //             $color = '#424242';
        //         } else {
        //             $color = '#e040fb';
        //         }
        //         $roster = $value->roster_start . '-' . $value->roster_end;
        //         $events[] = Calendar::event(
        //             // _lang('attendance.status', $value->status),
        //             $roster,
        //             true,
        //             // new \DateTime($value->roster_start),
        //             // new \DateTime($value->roster_end . ' +1 day'),
        //             $value->roster_start,
        //             $value->roster_end,
        //             $value->id,
        //             // Add color and link on event
        //             [
        //                 'color' => $color,
        //                 // 'url' => 'pass here url and any route',
        //             ]
        //         );
        //     }
        // }

        // $calendar = Calendar::addEvents($events)
        //     ->setOptions([ //set fullcalendar options
        //         // 'defaultDate' => date('Y-m-d', strtotime("+1 month"))
        //         'defaultDate' => date('Y-m-d', strtotime("" . $year . "-" . $month . "-01")),
        //         'header' => [
        //             // 'left' => 'today prev,next',
        //             'left' => null,
        //             'center' => 'title',
        //             // 'right' =>'month',
        //             'right' => null
        //         ],
        //     ])
        //     ->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        //         'eventClick' => 'function(e) {
        //                             console.log(e);
        //                              showModal();
        //                         }'
        //     ]);
        return view('user.attendance.user-attendance', compact('active', 'attendances', 'month', 'year'));
    }

    public function attendanceChangeRequest(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'roster_start' => 'required_with:roster_end',
        //     'roster_end' => 'required_with:roster_start',
        //     'punch_in' => 'required_with:punch_out',
        //     'punch_out' => 'required_with:punch_in',
        //     'remarks' => 'required',
        // ]);
        if ($request->get('submit') == "attendance_change") {
            $validator = Validator::make($request->all(), [
                'change_date' => 'required',
                'punch_in' => 'required',
                'punch_out' => 'required',
                'remarks' => 'required',
                'status' => 'required',
            ]);
        } elseif ($request->get('submit') == "roster_change") {
            $validator = Validator::make($request->all(), [
                'change_date' => 'required|after:today',
                'roster_start' => 'required_without:is_adjusted_day_off',
                'roster_end' => 'required_without:is_adjusted_day_off',
                'is_adjusted_day_off' => 'required_without:roster_start,roster_end',
                'remarks' => 'required',
                'status' => 'required',
            ]);
        }

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }


        $changeDate = $request->get('change_date');
        $now = Carbon::now();
        $length = $now->diffInDays($changeDate);

        // dd($request->all());

        // check if the request date more than 15 days
        // TODO 15 days atteance chage block
        if ($length > 15 && $request->get('submit') == "attendance_change") {
            toastr()->error("You can't apply for 15 days before.", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            return redirect()->back();
        }

        $roster = $this->attendanceDateCalculate($changeDate, $request->get('roster_start'), $request->get('roster_end'));
        $attendance = $this->attendanceDateCalculate($changeDate, $request->get('punch_in'), $request->get('punch_out'));


        $attendanceChangeRequest = new AttendanceChangeRequest();
        $attendanceChangeRequest->employee_id = auth()->user()->employee_id;
        $attendanceChangeRequest->date = $changeDate;
        $attendanceChangeRequest->roster_start = $request->get("is_adjusted_day_off") ? null : $roster['start_time'];
        $attendanceChangeRequest->roster_end = $request->get("is_adjusted_day_off") ? null : $roster['end_time'];
        $attendanceChangeRequest->punch_in = $request->get("is_adjusted_day_off") ? null : $attendance['start_time'];
        $attendanceChangeRequest->punch_out = $request->get("is_adjusted_day_off") ? null : $attendance['end_time'];
        $attendanceChangeRequest->out_of_office = $request->get("is_adjusted_day_off") ? null : $request->get('out_of_office');
        $attendanceChangeRequest->is_adjusted_day_off = $request->get("is_adjusted_day_off") ? 1 : 0;
        $attendanceChangeRequest->remarks = $request->get('remarks');
        $attendanceChangeRequest->status = $request->get('status');
        $attendanceChangeRequest->created_by = auth()->user()->employee_id;
        $attendanceChangeRequest->save();

        if ($request->get('submit') == "attendance_change") {
            toastr()->success("Your attendance change request submitted", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        } elseif ($request->get('submit') == "roster_change") {
            toastr()->success("Your roster change request submitted", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        } else {
            toastr()->error('Something went wrong.');
        }
        return redirect()->back();
    }

    public function attendanceDateCalculate($start_date, $start_time, $end_time)
    {
        // dd(Carbon::parse($start_date.' '.$start_time));
        // Carbon::parse($start_date)->addDays(1)->format('Y-m-d')
        // dd(Carbon::parse($end_time)->greaterThan(Carbon::parse($start_time)));
        if ($start_time && $end_time) {
            if (Carbon::parse($start_time)->greaterThan(Carbon::parse($end_time))) {
                $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_date . ' ' . $start_time);
                $end_time = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($start_date)->addDays(1)->format('Y-m-d') . ' ' . $end_time);
            } else {
                $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_date . ' ' . $start_time);
                $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_date . ' ' . $end_time);
            }
        } else {
            $start_time = null;
            $end_time = null;
        }
        return [
            'start_time' => $start_time,
            'end_time' => $end_time
        ];
    }

    public function attendanceChangeApproval()
    {
        $active = 'change-request';

        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();

        $leavesToHot = [];
        $changeRequests = null;
        if ($leadingTeams) {
            $employeeIds = $this->getTeamMembersId($leadingTeams);
            $leadingTeamsEmployeeIds = $employeeIds["team-members"];

            // $changeRequests = AttendanceChangeRequest::whereIn('employee_id', $leadingTeamsEmployeeIds)->where('first_approve_status', 0)->where('final_approve_status', 0)->get();
            $changeRequests = AttendanceChangeRequest::whereIn('employee_id', $leadingTeamsEmployeeIds)->orderBy('first_approve_status', 'asc')->orderBy('final_approve_status', 'asc')->paginate(10);
        }

        return view(
            'user.attendance.change-request',
            compact(
                'active',
                'changeRequests'
            )
        );
    }

    public function getTeamMembersId($teams)
    {

        $teamMembers = [];
        $childTeamMembers = [];
        foreach ($teams as $team) {
            $teamMembers[] = $team->employees()->select('employees.id')->wherePivot('member_type', TeamMemberType::MEMBER)->get();
        }
        $employeeIds = [];
        foreach ($teamMembers as $items) {
            foreach ($items as $item) {
                $employeeIds[] = ($item->id) ? $item->id : null;
            }
        }

        //return $employeeIds;
        return array(
            'team-members' => $employeeIds
        );
    }


    public function attendanceChangeApprovalSubmit(Request $request)
    {
        $change_request = AttendanceChangeRequest::find($request->get('change_id'));
        if ($request->get('submit') == 'approve') {
            $change_request->first_approve_status = AttendanceChangeStatus::APPROVED;
            $change_request->save();
            toastr()->success("You approved the request.", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        } elseif ($request->get('submit') == 'reject') {
            $change_request->first_approve_status = AttendanceChangeStatus::REJECTED;
            $change_request->save();
            toastr()->error("You rejected the request.", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        }
        return redirect()->back();
    }

    public function hourlyAttendance(Request $request){
        $active = 'user-hourly-attendance';

        $month = $request->has('month') ? date('Y-m', strtotime($request->input('month'))) : date('Y-m');
        $year = $request->has('month') ? date('Y', strtotime($request->input('month'))) : date('Y');

        $thisMonth = date('Y-m-15', strtotime($month));
        $lastMonth = date('Y-m-16', strtotime("-1 months", strtotime($month)));
        $attendances = [];
        $employee = Employee::find(\Auth::user()->employee_id);
        // if($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::HOURLY){
        //     $attendances = EmployeeHours::where('employee_id', \Auth::user()->employee_id)->whereBetween('date', [$lastMonth, $thisMonth])->get();
        // }
        $attendances = EmployeeHours::where('employee_id', \Auth::user()->employee_id)->whereBetween('date', [$lastMonth, $thisMonth])->get();
        return view('user.attendance.user-hourly-attendance', compact('active', 'attendances', 'month', 'year'));
    }
}
