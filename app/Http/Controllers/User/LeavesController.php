<?php

namespace App\Http\Controllers\User;

use App\Attendance;
use App\Department;
use App\EarnLeave;
use App\LeaveBalanceSetting;
use App\LeaveDocument;
use App\LeaveRule;
use App\Notifications\LeaveApply;
use App\Process;
use App\Services\EarnLeaveService;
use App\Services\LeaveService;
use App\Team;
use App\TeamLeaveStatus;
use App\Utils\AttendanceStatus;
use App\Utils\EmploymentTypeStatus;
use App\Utils\TeamMemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Leave;
use App\User;
use DB;
use Validator;
use App\Workflow;
use App\Employee;
use App\ApprovalProcess;
use App\EmployeeJourney;
use App\EmployeeTeam;
use App\LeaveBalance;
use App\LeaveReason;
use App\LeaveType;
use App\ProcessOrdering;
use App\SetLeave;
use App\TeamWorkflow;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Calendar;
use App\Holiday;
use PDF;

class LeavesController extends Controller
{
    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function leaveDashboard($id = null, Request $request)
    {
        $active = 'leave-dashboard';
        $attendance_data        =   Attendance::where('employee_id', auth()->user()->employee_id);
        $total_late_entry       =   $attendance_data->where('status', AttendanceStatus::LATE)->whereYear('created_at', \Carbon\Carbon::parse(date('Y-m-d'))->format('Y'))->whereMonth('created_at', \Carbon\Carbon::parse(date('Y-m-d'))->format('m'))->count();
        $total_absent           =   $attendance_data->where('status', AttendanceStatus::ABSENT)->whereYear('created_at', \Carbon\Carbon::parse(date('Y-m-d'))->format('Y'))->whereMonth('created_at', \Carbon\Carbon::parse(date('Y-m-d'))->format('m'))->count();
        $total_early_leave      =   0;

        // TODO complete leave dashboard and with attendance calander and roster table
        // $roster = $attendance_data->whereYear('date', Carbon::parse(date('Y-m-d'))->format('Y'))->whereMonth('date', \Carbon\Carbon::parse(date('Y-m-d'))->format('m'))->get();

        $month = ($request->has('month')) ? $request->get('month') : Carbon::now()->format('m');
        $year = ($request->has('year')) ? $request->get('year') : Carbon::now()->format('Y');
        // dd($month);
        $rosters = Attendance::where('employee_id', auth()->user()->employee_id)->whereYear('date', $year)->whereMonth('date', $month)->where('date' , '<', Carbon::now()->format('Y-m-d 00:00:00'))->get();
        $approvedLeaves = Leave::where('employee_id', auth()->user()->employee_id)->where('leave_status', LeaveStatus::APPROVED)->whereYear('start_date', $year)->whereMonth('start_date', $month)->count();
        $approvedLeaveDates = Leave::where('employee_id', auth()->user()->employee_id)->where('leave_status', LeaveStatus::APPROVED)->whereYear('start_date', $year)->whereMonth('start_date', $month)->pluck('leave_days');
        $approvedLeavesData = Leave::where('employee_id', auth()->user()->employee_id)->where('leave_status', LeaveStatus::APPROVED)->whereYear('start_date', $year)->whereMonth('start_date', $month)->get();
        // dd($approvedLeaveDates);
        $leave_dates = [];
        foreach($approvedLeaveDates as $date){
            $row_dates = json_decode($date);            
            foreach($row_dates as $row){
                array_push($leave_dates, $row);
            }
        }
        // dd($leave_dates);
        $events = [];
        if ($rosters->count()) {
            foreach ($rosters as $key => $value) {
                if ($value->status == AttendanceStatus::ABSENT) {
                    $color = '#fd397a ';
                } elseif ($value->status == AttendanceStatus::PRESENT) {
                    $color = 'green';
                } elseif ($value->status == AttendanceStatus::LATE) {
                    $color = '#ffb822';
                } else {
                    $color = '#f05050';
                }
                $events[] = Calendar::event(
                    // _lang('attendance.status', $value->status),
                    'genex',
                    true,
                    // new \DateTime($value->roster_start),
                    // new \DateTime($value->roster_end . ' +1 day'),
                    $value->roster_start,
                    $value->roster_end,
                    $value->id,
                    // Add color and link on event
                    [
                        'color' => $color,
                        // 'url' => 'pass here url and any route',
                    ]
                );
            }
        }
        // dd($events);
        $calendar = Calendar::addEvents($events)
            ->setOptions([ //set fullcalendar options
                // 'defaultDate' => date('Y-m-d', strtotime("+1 month"))
                'defaultDate' => date('Y-m-d', strtotime("" . $year . "-" . $month . "-01")),
                'header' => [
                    // 'left' => 'today prev,next',
                    'left' => null,
                    'center' => 'title',
                    // 'right' =>'month',
                    'right' => null
                ],
            ])
            ->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'eventClick' => 'function(e) {
                                    console.log(e);
                                     showModal();
                                }'
            ]);
        return view(
            'user.leave.leave-dashboard',
            compact(
                'active',
                'id',
                'total_absent',
                'total_late_entry',
                'total_early_leave',
                'approvedLeaves',
                'approvedLeavesData',
                'leave_dates',
                'rosters',
                'calendar',
                'month',
                'year'
            )
        );
    }


    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function leaveDetails($id = null)
    {
        $active = 'leave-details';
        $employee_id = ($id == null) ? auth()->user()->employee_id : $id;
        if($id != null){
            $active = 'team-leave-history';
        }
        $employee = Employee::where('id', $employee_id)->first();
        //$balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))->get();


        $leaveBalances = LeaveBalance::where('employee_id', $employee_id)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->get();
        $leaves = Leave::where('employee_id', $employee_id)->latest()->paginate(10);
         //dd($leaveBalances);
        return view('user.leave.leave-detail', compact('active', 'leaves', 'leaveBalances', 'id', 'employee'));
    }


    public function leaveView($id, $approval_type = null, $approval_id = null)
    {
        $active = 'leave-view';
        $leave = Leave::find($id); //Get this leave data
        $type="hot";
        // Leave Balance
        $leave_type = $leave->leave_type_id;
        $employee_id = $leave->employee_id;
        $balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
            ->select('leave_type_id', 'total', 'used', 'remain')
            ->get();
        //Leave Balance

        return view('user.leave.leave-view', compact('active', 'leave', 'id', 'approval_id', 'approval_type', 'type', 'balances', 'leave_type'));
    }


    public function leaveDownload($id){
        $leave = Leave::find($id); //Get this leave data
        $type="hr";
        // Leave Balance
        $leave_type = $leave->leave_type_id;
        $employee_id = $leave->employee_id;
        $balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
            ->select('leave_type_id', 'total', 'used', 'remain')
            ->get();
        //Leave Balance

        $data = [
            'title' => 'Leave Application PDF',
            'leave' => $leave,
            'leave_type' => $leave_type,
            'employee_id' =>  $employee_id,
            'balances' => $balances
        ];

        $pdf = PDF::loadView('user.leave.leave-download', $data);
        return $pdf->download('Leave_Application.pdf');
    }


    /**
     * @method: leaveApplication
     * @param :
     * @return void
     *
     */
    public function leaveApplication()
    {
        $active = 'leave-apply';
        $leaveReasons = LeaveReason::all()->filter(function ($value, $key) {
            return data_get($value, 'id') != 6;
        });

        $maternity_leave = LeaveBalanceSetting::where('employment_type_id', auth()->user()->employeeDetails->employeeJourney->employment_type_id)->where('leave_type_id', LeaveStatus::MATERNITY)->first();
        $maternity_leave = ($maternity_leave) ? $maternity_leave->quantity : null;

        $paternity_leave = LeaveBalanceSetting::where('employment_type_id', auth()->user()->employeeDetails->employeeJourney->employment_type_id)->where('leave_type_id', LeaveStatus::PATERNITY)->first();
        $paternity_leave = ($paternity_leave) ? $paternity_leave->quantity : null;

        $leaveTypes = LeaveBalance::where('employee_id', auth()->user()->employee_id)
            ->where('year', date('Y'))
            ->where('employment_type_id', auth()->user()->employeeDetails->employeeJourney->employment_type_id)
            ->where('remain', '>', 0)
            //->where('is_usable', 1)
            ->get();

        $earnLeave = LeaveBalance::where('employee_id', auth()->user()->employee_id)
            ->where('year', date('Y'))
            ->where('employment_type_id', auth()->user()->employeeDetails->employeeJourney->employment_type_id)
            ->where('leave_type_id', LeaveStatus::EARNED)
            //->where('is_usable', 1)
            ->first();

        if ($earnLeave && ($earnLeave->total == $earnLeave->used)) {
            $earnLeave = auth()->user()->employeeDetails->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first();

            if ($earnLeave && ($earnLeave->forwarded_balance > 0)) {
                $has_earnLeave = true;
            } else {
                $has_earnLeave = false;
            }
        } elseif ($earnLeave && ($earnLeave->total != $earnLeave->used)) {
            $has_earnLeave = true;
        } else {
            $has_earnLeave = false;
        }


        return view('user.leave.leave-application', compact('active', 'leaveReasons', 'leaveTypes', 'maternity_leave', 'paternity_leave', 'has_earnLeave'));
    }

    public function leaveApply(Request $request)
    {
         //dd($request);

        $today = Carbon::now();
        $canApply = $today->subDays(15)->format('Y-m-d');

        $employeeID = $request->input('employee_id');
        $employee = Employee::whereId($employeeID)->with('employeeJourney')->first();
        $startDate = Carbon::create($request->input('start_date'));
        $endDate = Carbon::create($request->input('end_date'));
        //$quantity = ($request->input('half_day')) ? 0.5 : $startDate->diffInDays($endDate) + 1;
        $teamBelongs = $employee->teamMember()->wherePivot('member_type', TeamMemberType::MEMBER)->first();
        $isBridge = false;
        $day_off_start = $employee->fixedOfficeTime->where('is_offday', 1)->where('day', Carbon::parse($startDate)->format('l'));
        //dd($day_off_start->count());
        if($day_off_start->count()){
            toastr()->error("Start date is day off!");
            return redirect()->back()->withInput();
        }
        $leaveService = new LeaveService($employee, $request);
        //$leaveCheck = $leaveService->leaveCheck($startDate, $endDate, $isBridge);
        $leaveCheck = $leaveService->leaveCheck($startDate, $endDate);
        $checkLeaveIsUsable = $leaveService->checkLeaveIsUsable($leaveCheck['count']);
        if($checkLeaveIsUsable){
            return redirect()->back()->withInput();
        }
        if($leaveCheck['redirectBack']){
            return redirect()->back()->withInput();
        }

        //dd($checkLeaveIsUsable);


        $quantity = ($request->input('half_day')) ? 0.5 : $leaveCheck['count'];
        if($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PROBATION){
            $earnLeaveService = new EarnLeaveService($employee);
            $availableBalance = 0;
            if($request->get('leave_type_id') == LeaveStatus::CASUAL){
                $availableBalance = $earnLeaveService->proratedCasualLeaveRemain();
            }elseif($request->get('leave_type_id') == LeaveStatus::SICK){
                $availableBalance = $earnLeaveService->proratedSickLeaveRemain();
            }elseif ($request->get('leave_type_id') == LeaveStatus::EARNED) {
                $availableBalance = $earnLeaveService->earnLeaveRemain();
            }elseif($request->get('leave_type_id') == LeaveStatus::LWP){
                $availableBalance = $employee->leaveBalances()
                    ->where('year', date('Y'))
                    ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
                    ->where('leave_type_id', LeaveStatus::LWP)
                    //->where('is_usable', 1)
                    ->first();
            }


            if($request->input('leave_type_id') != LeaveStatus::LWP){
                if($availableBalance < $quantity){
                    toastr()->error("You don't have sufficient balance.");
                    return redirect()->back()->withInput();
                }
            }
        }
        if($quantity > 1 && $request->input('leave_type_id') == LeaveStatus::SICK){
            $validator = Validator::make($request->all(), [
                'start_date' => "after:" . $canApply,
                'end_date' => "after_or_equal:start_date",
                'leave_reason_id' => "required",
                'file' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:5000|required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'start_date' => "after:" . $canApply,
                'end_date' => "after_or_equal:start_date",
                'leave_reason_id' => "required",
                'file' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:5000'
            ]);
        }

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }

        //if($request->input('leave_type_id') != LeaveStatus::SICK){
        //
        //    // check if holiday
        //    $start_next_date = Carbon::create($request->input('start_date'))->addDays(1);
        //    $end_prev_date = Carbon::create($request->input('end_date'))->subDays(1);
        //    $leave_in_middle_start = Carbon::create($request->input('start_date'))->subDays(1);
        //    $leave_in_middle_end = Carbon::create($request->input('start_date'))->addDays(1);
        //
        //    //$checkStartEnd = Holiday::where('start_date', $start_next_date)->where('end_date', $end_prev_date)->first();
        //    $checkStartEnd = Holiday::whereJsonContains('religion->religion', [$employee->religion])
        //        ->whereHas('centers', function ($q) use ($employee){
        //            $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
        //        })
        //        ->where('start_date', '<=', $start_next_date)->where('end_date', '>=', $end_prev_date)
        //        ->first();
        //
        //
        //
        //
        //    //$checkInMiddle = Holiday::where('start_date', $leave_in_middle_end)->orWhere('end_date', $leave_in_middle_start)->get();
        //    $checkInMiddle = Holiday::where(function($q) use ($leave_in_middle_start, $leave_in_middle_end, $employee){
        //        $q->whereJsonContains('religion->religion', [$employee->religion])
        //            ->whereHas('centers', function ($q) use ($employee){
        //                $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
        //            })
        //            ->where('start_date', $leave_in_middle_end);
        //    })
        //        ->orWhere(function($q) use ($leave_in_middle_start, $leave_in_middle_end, $employee){
        //            $q->whereJsonContains('religion->religion', [$employee->religion])
        //                ->whereHas('centers', function ($q) use ($employee) {
        //                    $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
        //                })->where('end_date', $leave_in_middle_start);
        //        })
        //        ->get();
        //    toastr()->warning('You have holiday in between your start and end date. This will considered as a bridge.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        //    //$checkStartEnd = null;
        //    if($checkStartEnd){
        //        $isBridge = true;
        //        $leaveCheck = $leaveService->leaveCheck($startDate, $endDate, $isBridge);
        //        $quantity = ($request->input('half_day')) ? 0.5 : $leaveCheck['count'];
        //    }
        //    if($checkInMiddle){
        //        if($checkInMiddle->count() == 2){
        //            if($request->input('leave_type_id') == LeaveStatus::CASUAL){
        //                toastr()->error('You can not apply for CL for this day. This will be a bridge otherwise.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        //                return redirect()->back()->withInput();
        //            }
        //            if($checkInMiddle[0]){
        //                $startDate = Carbon::create($checkInMiddle[0]['start_date']);
        //            }
        //            if($checkInMiddle[1]){
        //                $endDate = Carbon::create($checkInMiddle[1]['end_date']);
        //            }
        //            $isBridge = true;
        //            $leaveCheck = $leaveService->leaveCheck($startDate, $endDate, $isBridge);
        //            $quantity = ($request->input('half_day')) ? 0.5 : $leaveCheck['count'];
        //        }
        //    }
        //
        //
        //
        //    // dd($day_offs);
        //    // dd($startDate);
        //}
        //dd('ok');

        //check if already applied for leave.
        if ($leaveService->appliedLeaveCheck($startDate, $endDate)) {
            toastr()->error('You have already applied leave for these days.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            return redirect()->back()->withInput();
        }

        // check if he/she belongs to any team as a member
        if ($teamBelongs) {
            $leaveRuleId = $teamBelongs->leaveRule->id;
        } else {
            toastr()->error("You don't seem to belong to any team. Please contact with your Supervisor or HR.");
            return redirect()->back();
        }

        $leave = new Leave();
        $leave->employee_id = $employeeID;
        $leave->subject = $request->input('subject');
        $leave->description = $request->input('description');
        $leave->start_date = $startDate->format('Y-m-d');
        $leave->end_date = $endDate->format('Y-m-d');
        $leave->leave_reason_id = $request->input('leave_reason_id');
        $leave->leave_type_id = $request->input('leave_type_id');
        $leave->half_day = $request->input('half_day');
        $leave->leave_location = $request->input('leave_location');
        $leave->resume_date = $request->input('resume_date');
        $leave->quantity = $quantity;
        $leave->leave_status = LeaveStatus::PENDING;
        $leave->leave_days = json_encode($leaveCheck['days']);

        // dd($leave);

        //if (($request->input('leave_type_id') == LeaveStatus::EARNED)){
        //    $earnLeaveService = new EarnLeaveService(auth()->user()->employeeDetails);
        //    $leaveBalance = $earnLeaveService->earnLeaveRemain();
        //    $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($quantity);
        //    dd($earnLeaveApplyPolicy);
        //}



        $leaveBalance = LeaveBalance::where('employee_id', $employeeID)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', $request->input('leave_type_id'))
            ->when(($request->input('leave_type_id') != LeaveStatus::LWP), function ($q) use ($leave) {
                return $q->where('remain', '>=', $leave->quantity);
            })
            ->first();



        $earnLeaveApplyPolicy = null;
        if (($request->input('leave_type_id') == LeaveStatus::EARNED)) {
            //$leaveBalance = auth()->user()->employeeDetails->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first()->forwarded_balance;
            $earnLeaveService = new EarnLeaveService(auth()->user()->employeeDetails);
            //$leaveBalance = $earnLeaveService->earnLeaveRemain();
            $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($quantity);
            if ($earnLeaveApplyPolicy['can_apply']) {
                $leave->from_forwarded_el = ($earnLeaveApplyPolicy['from_forwarded_el']) ? $earnLeaveApplyPolicy['from_forwarded_el'] : null; // leave applied from forwarded leave balance
            }
        }



        if ($leaveBalance || $earnLeaveApplyPolicy['can_apply']) {
            //            check attendance table
            //            $attendances = Attendance::whereEmployeeId($employeeID)->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get();
            //            if ($attendances->count()) {
            //                foreach ($attendances as $attendance) {
            //                    // TODO can apply leave but skipping day off and public holidays
            //                    if ($attendance->status == AttendanceStatus::DAYOFF || $attendance->status == AttendanceStatus::HOLIDAY) {
            //                        toastr()->error('You are applying leave on "Day Off" or "Holiday".');
            //                        return redirect()->back();
            //                    } elseif ($attendance->status == AttendanceStatus::PRESENT) {
            //                        toastr()->error('You were present on ' . $attendance->date, 'Sorry!');
            //                        return redirect()->back();
            //                    }
            //                }
            //            }

            if($isBridge == false){
                foreach ($leaveCheck['days'] as $leaveDay) {
                    $attendance = Attendance::whereEmployeeId($employeeID)->where('date', $leaveDay)->first();
                    if ($attendance) {
                        if ($attendance->status == AttendanceStatus::DAYOFF || $attendance->status == AttendanceStatus::HOLIDAY) {
                            toastr()->error('You are applying leave on "Day Off" or "Holiday".');
                            return redirect()->back();
                        } elseif ($attendance->status == AttendanceStatus::PRESENT) {
                            toastr()->error('You were present on ' . $attendance->date, 'Sorry!');
                            return redirect()->back();
                        }
                    }
                }
            }

            // supervisors
            $fetchSupervisors = $teamBelongs->employees()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get();
            $fetchHeadOfTeam = $teamBelongs->employees()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->first();

            $supervisors = [];
            if ($fetchSupervisors) {
                foreach ($fetchSupervisors as $sup) {
                    $supervisors[] = $sup->userDetails;
                }
            }

            (!empty($supervisors)) ? $leave->leave_rule_id = $leaveRuleId : $leave->leave_rule_id = null;


            // insert leave document file name to database
            if ($request->has('file')) {
                // upload leave document
                $name = $this->documentUpload($request);
                if ($name) {
                    // save leave
                    $leave->save();
                    // save file name
                    $leave->leaveDocuments()->save(new LeaveDocument(['file_name' => $name]));
                    if ($supervisors) {
                        //send notification to supervisors
                        Notification::send($supervisors, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
                        //send notification to hot
                        Notification::send($fetchHeadOfTeam->userDetails, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
                    } else {
                        //send notification to hot
                        Notification::send($fetchHeadOfTeam->userDetails, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
                    }
                }
            } else {
                // save leave
                $leave->save();
                if ($supervisors) {
                    //send notification to supervisors
                    Notification::send($supervisors, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
                } else {
                    //send notification to hot
                    Notification::send($fetchHeadOfTeam->userDetails, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
                }
            }
            toastr()->success('Leave successfully applied');
        } else if (($request->input('leave_type_id') == LeaveStatus::LWP)) {
            //$leaveService = new LeaveService($employee, $request);
            //$leaveService->leaveBalanceGenerate($employee->employeeJourney->employment_type_id, $request->input('probation_start_date'), $request->input('permanent_doj'));
            //dd($earnLeaveApplyPolicy['can_apply']);
            $leave->save();
            $fetchSupervisors = $teamBelongs->employees()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get();
            $fetchHeadOfTeam = $teamBelongs->employees()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->first();
            $supervisors = [];
            if ($fetchSupervisors) {
                foreach ($fetchSupervisors as $sup) {
                    $supervisors[] = $sup->userDetails;
                }
            }

            (!empty($supervisors)) ? $leave->leave_rule_id = $leaveRuleId : $leave->leave_rule_id = null;
            if ($supervisors) {
                //send notification to supervisors
                Notification::send($supervisors, new LeaveApply($leave, $employee->FullName, ' have sent a LWP request.', 'leave.request'));
            } else {
                //send notification to hot
                Notification::send($fetchHeadOfTeam->userDetails, new LeaveApply($leave, $employee->FullName, ' have sent a LWP request.', 'leave.request'));
            }
            toastr()->success('Leave application sent successfully.');
        } else {
            toastr()->error('You do not have required balance.');
            return redirect()->back();
        }

        return redirect()->route('leave.list');
    }

    // leave document upload
    public function documentUpload(Request $request)
    {
        $path = storage_path('app/public/employee/leave_documents');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        } else {
            if (!chmod($path, 0777)) {
                return "Unable to chmod $path";
            }
        }

        $file = $request->file('file');
        //        foreach ($files as $file) {
        $name = uniqid() . '_' . str_replace(" ", "_", trim($file->getClientOriginalName()));
        $file->move($path, $name);
        //        }
        //        return response()->json([
        //            'name'          => $name,
        //            'original_name' => $file->getClientOriginalName(),
        //        ]);
        //        return response()->json($data);
        return $name;
    }



    //    request applications
    //    public function requestedApplicationList(Request $request)
    //    {
    //        $active = 'team-leave-request';
    //
    //        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();
    //        $is_supervisor_exists = false;
    //
    //        $leavesToHot = [];
    //        if ($leadingTeams) {
    //            $leadingTeamsEmployeeIds = $this->getTeamMembersId($leadingTeams);
    //            //dd($leadingTeamsEmployeeIds);
    //            //$leavesToHot = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)->whereNull('leave_rule_id')->whereNull('hot_approved_by')->whereNull('rejected_by');
    //            //$leavesToHot = [];
    //            foreach ($leadingTeamsEmployeeIds as $empId){
    //
    //                $empTeam = Employee::find($empId)->teamMember()->wherePivotIn('member_type', [TeamMemberType::MEMBER])->first();
    //
    //                $is_supervisor_exists = ($empTeam->employees()->having('pivot_member_type', TeamMemberType::SUPERVISOR)->get()->count()) ? true : false;
    //                //dd(count($is_supervisor_exists));
    //            }
    //            if($is_supervisor_exists){
    //                //$leavesToHot[] = Leave::where('employee_id', $empId)->whereNotNull('supervisor_approved_by')->whereNull('hot_approved_by')->whereNull('rejected_by')->get();
    //                $leavesToHot = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)->whereNotNull('supervisor_approved_by')->whereNull('hot_approved_by')->whereNull('rejected_by')->get();
    //            }else{
    //                $leavesToHot = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)->whereNull('leave_rule_id')->whereNull('hot_approved_by')->whereNull('rejected_by')->get();
    //            }
    //            //$leavesToHot = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)->whereNull('leave_rule_id')->whereNull('hot_approved_by')->whereNull('rejected_by')->get();
    //            //dd($leavesToHot);
    //        }
    //
    //
    //
    //        $supervisedTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::SUPERVISOR])->get();
    //        if ($supervisedTeams) {
    //            $supervisedTeamsEmployeeIds = $this->getTeamMembersId($supervisedTeams);
    //            $leavesToSupervisor = Leave::whereIn('employee_id', $supervisedTeamsEmployeeIds)->whereNotNull('leave_rule_id')->where('leave_status', 0)->whereNull('supervisor_approved_by')->whereNull('rejected_by')->get();
    //            //dd($supervisedTeamsEmployeeIds);
    //        } else {
    //            $leavesToSupervisor = null;
    //        }
    //
    //        return view('user.leave.request-application', compact('active', 'leavesToHot', 'leavesToSupervisor'));
    //    }

    public function requestedApplicationList(Request $request)
    {
        $active = 'team-leave-request';

        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();

        $leavesToHot = [];
        if ($leadingTeams) {
            $employeeIds = $this->getTeamMembersId($leadingTeams);
            $leadingTeamsEmployeeIds = $employeeIds["team-members"];
            $childTeamsEmployeeIds = $employeeIds["child-team-members"];

            $leavesToHot = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)->whereNull('supervisor_approved_by')->whereNull('hot_approved_by')->whereNull('rejected_by')->get();
            $leavesToUpperHot = Leave::whereIn('employee_id', $childTeamsEmployeeIds)->whereNotNull('supervisor_approved_by')->whereNull('hot_approved_by')->whereNull('rejected_by')->get();
            $leaveCancelRequests = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)
                ->whereNotNull('hot_approved_by')
                ->where('leave_status', LeaveStatus::APPROVED)
                ->whereNull('rejected_by')
                ->where('cancel_request', 1)
                ->get();
        }

        return view('user.leave.request-application', compact('active', 'leavesToHot', 'leavesToUpperHot', 'leaveCancelRequests'));
    }

    public function getTeamMembersId($teams)
    {

        $teamMembers = [];
        $childTeamMembers = [];
        foreach ($teams as $team) {
            $teamMembers[] = $team->employees()->select('employees.id')->wherePivot('member_type', TeamMemberType::MEMBER)->get();
            if ($team->children->count()) {
                foreach ($team->children as $childTeam) {
                    $childTeamMembers[] = $childTeam->employees()->select('employees.id')->wherePivot('member_type', TeamMemberType::MEMBER)->get();
                }
            }
        }
        $employeeIds = [];
        $childEmployeeIds = [];
        foreach ($teamMembers as $items) {
            foreach ($items as $item) {
                $employeeIds[] = ($item->id) ? $item->id : null;
            }
        }

        if ($childTeamMembers) {
            foreach ($childTeamMembers as $items) {
                foreach ($items as $item) {
                    $childEmployeeIds[] = ($item->id) ? $item->id : null;
                }
            }
        }

        //return $employeeIds;
        return array(
            'team-members' => $employeeIds,
            'child-team-members' => $childEmployeeIds
        );
    }

    // //    leave application details view modal ajax
    // public function leaveView($id, $approval_type = null, $approval_id = null)
    // {
    //     $active = 'leave-view';
    //     $type = "";
    //     $leave = Leave::find($id); //Get this leave data
    //     // Leave Balance
    //     $leave_type = $leave->leave_type_id;
    //     $employee_id = $leave->employee_id;
    //     $balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
    //         ->select('leave_type_id', 'total', 'used', 'remain')
    //         ->get();
    //     //Leave Balance

    //     return view('user.leave.leave-view', compact('active', 'leave', 'id', 'approval_id', 'approval_type', 'type', 'balances', 'leave_type'));
    // }

    //    leave approval
    //    public function leaveApproval(Request $request)
    //    {
    //        dd($request->input('approval_type'));
    //        $leave = Leave::find($request->input('leave_id'));
    //        $employee = Employee::find($leave->employee_id);
    //        $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
    //            ->where('year', date('Y'))
    //            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
    //            ->where('leave_type_id', $leave->leave_type_id)
    //            ->where('remain', '>=', $leave->quantity)
    //            ->first();
    //        $teamBelongs = $employee->teamMember()->wherePivotIn('member_type', [TeamMemberType::MEMBER])->first();
    //        $fetchUpperHeadOfTeam = ($teamBelongs->parent_id) ? $teamBelongs->parent->teamLead : null;
    //        if ($leaveBalance) {
    //            if ($request->input('submit') == "Approved") {
    //                if ($request->input('approval_type') == 'supervisor') {
    //                    $leave->supervisor_approved_by = $request->input('approval_id');
    //                    $leave->save();
    //                    // send notification to Head of Team
    //                    $hot = $teamBelongs->teamLead->userDetails;
    //                    Notification::send($hot, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
    //
    //                    toastr()->success('Leave Approved from supervisor end.');
    //                } elseif ($request->input('approval_type') == 'team_leader') {
    //                    // check attendance table and update leave status
    //                    $attendances = Attendance::whereEmployeeId($employee->id)->whereBetween('date', [$leave->strat_date, $leave->end_date])->get();
    //                    if ($attendances->count()) {
    //                        foreach ($attendances as $attendance) {
    //                            $attendance->status = $leave->leave_type_id;
    //                            $attendance->save();
    //                        }
    //                    }
    //
    //
    //                    $leave->hot_approved_by = $request->input('approval_id');
    //                    $leave->leave_status = LeaveStatus::APPROVED;
    //
    ////                    deduct leave from employee leave balance
    //                    $leaveBalance->decrement('remain', $leave->quantity);
    //                    $leaveBalance->increment('used', $leave->quantity);
    //
    //                    $leave->save();
    //                    // send notification to the employee for approve leave
    //                    Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave has been approved', 'leave.list'));
    //                    toastr()->success('Leave Approved.');
    //                }
    //            } elseif ($request->input('submit') == "Reject") {
    //                $leave->leave_status = LeaveStatus::REJECT;
    //                $leave->remarks = $request->input('remarks');
    //                $leave->rejected_by = $request->input('approval_id');
    //                $leave->save();
    //                // send notification to the employee for reject leave
    //                Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave request has been rejected', 'leave.list'));
    //
    //                toastr()->success('Leave Rejected.');
    //            }
    //        } else {
    //            toastr()->error($employee->FullName . ' dose not have required balance.');
    //        }
    //
    //
    //        return redirect()->back();
    //    }

    public function leaveApproval(Request $request)
    {
        $leave = Leave::find($request->input('leave_id'));
        $employee = Employee::find($leave->employee_id);
        if ($request->input('approval_type') == 'cancel_leave') {
            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
                ->where('year', date('Y'))
                ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->first();            
            if ($leaveBalance) {
                DB::beginTransaction();

                try {


                    // check attendance table and update leave status
                    $attendances = Attendance::whereEmployeeId($employee->id)->whereBetween('date', [$leave->strat_date, $leave->end_date])->get();
                    if ($attendances->count()) {
                        foreach ($attendances as $attendance) {
                            $attendance->status = AttendanceStatus::ABSENT;
                            $attendance->save();
                        }
                    }

                    $leave->cancelled_by = $request->input('approval_id');
                    $leave->leave_status = LeaveStatus::CANCEL;

                    // deduct leave from employee leave balance
                    //if ($leave->from_forwarded_el){
                    //    $earnForwardedBalance = $employee->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first();
                    //    $earnForwardedBalance->increment('forwarded_balance', $leave->quantity);
                    //    $earnForwardedBalance->increment('total_balance', $leave->quantity);
                    //}else{
                    //    $leaveBalance->increment('remain', $leave->quantity);
                    //    $leaveBalance->decrement('used', $leave->quantity);
                    //}

                    if ($leave->leave_type_id == LeaveStatus::EARNED) {
                        if ($leave->from_forwarded_el) {
                            $earnForwardedBalance = $employee->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first();
                            $earnForwardedBalance->increment('forwarded_balance', $leave->from_forwarded_el);
                            $earnForwardedBalance->increment('total_balance', $leave->from_forwarded_el);
                            $leaveBalance->increment('remain', $leave->quantity - $leave->from_forwarded_el);
                            $leaveBalance->decrement('used', $leave->quantity - $leave->from_forwarded_el);
                        } elseif ($leave->from_forwarded_el == null) {
                            $leaveBalance->increment('remain', $leave->quantity);
                            $leaveBalance->decrement('used', $leave->quantity);
                        }
                    } else {
                        $leaveBalance->increment('remain', $leave->quantity);
                        $leaveBalance->decrement('used', $leave->quantity);
                    }

                    $leave->save();
                    // send notification to the employee for approve leave
                    Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave has been approved', 'leave.list'));
                    toastr()->success('Leave Approved.');

                    DB::commit();
                    // all good
                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    toastr()->error($e->getMessage());
                }

            } else {
                toastr()->error($employee->FullName . ' dose not have required balance.');
            }
            return redirect()->back();
        }
        $earnLeaveApplyPolicy = null;

        if ($leave->leave_type_id == LeaveStatus::EARNED) {
            $earnLeaveService = new EarnLeaveService($employee);
            $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($leave->quantity);
            //$leaveBalance = LeaveBalance::where('employee_id', $employee->id)
            //    ->where('year', date('Y'))
            //    ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            //    ->where('leave_type_id', $leave->leave_type_id)
            //    //->where('remain', '>=', $leave->quantity)
            //    ->first();
        }
        //else{
        $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->when($leave->leave_type_id != LeaveStatus::LWP, function ($q) use ($leave) {
                return $q->where('remain', '>=', $leave->quantity);
            })
            ->first();
        //}

        $teamBelongs = $employee->teamMember()->wherePivotIn('member_type', [TeamMemberType::MEMBER])->first();
        $fetchUpperHeadOfTeam = ($teamBelongs->parent_id) ? $teamBelongs->parent->teamLead : null;

        // dd($earnLeaveApplyPolicy['can_apply']);
        // dd($leaveBalance);
        // dd($teamBelongs);
        // dd($request->all());

        if ($leaveBalance || $earnLeaveApplyPolicy['can_apply'] || $leave->leave_type_id == LeaveStatus::LWP) {
            if ($request->input('submit') == "Approved") {
                if ($request->input('approval_type') == 'team_leader') {

                    if (!$teamBelongs->parent_id) {




                        $leave->hot_approved_by = $request->input('approval_id');

                        // deduct leave from employee leave balance
                        //$leaveBalance->decrement('remain', $leave->quantity);
                        //$leaveBalance->increment('used', $leave->quantity);
                        // deduct leave from employee leave balance
                        if ($leave->leave_type_id == LeaveStatus::EARNED) {
                            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
                                ->where('year', date('Y'))
                                ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
                                ->where('leave_type_id', $leave->leave_type_id)
                                //->where('remain', '>=', $leave->quantity)
                                ->first();
                            $earnLeaveService = new EarnLeaveService($employee);
                            $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($leave->quantity);

                            // dd($leave);
                            if ($leaveBalance && $leave->from_forwarded_el && $earnLeaveApplyPolicy['can_apply']) {
                                DB::beginTransaction();

                                try {
                                    $earnForwardedBalance = $employee->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first();
                                    $earnForwardedBalance->decrement('forwarded_balance', $leave->from_forwarded_el);
                                    $earnForwardedBalance->decrement('total_balance', $leave->from_forwarded_el);
                                    // $leaveBalance->decrement('remain', $leave->quantity - $leave->from_forwarded_el);
                                    // $leaveBalance->increment('used', $leave->quantity - $leave->from_forwarded_el);
                                    $leave->leave_status = LeaveStatus::APPROVED;
                                    DB::commit();
                                    // all good
                                } catch (\Exception $e) {
                                    $leave->leave_status = LeaveStatus::PENDING;
                                    DB::rollback();                                    
                                }

                            } elseif ($leaveBalance && $leave->from_forwarded_el == null && $earnLeaveApplyPolicy['can_apply']) {
                                // $leaveBalance->decrement('remain', $leave->quantity);
                                // $leaveBalance->increment('used', $leave->quantity);
                                $leave->leave_status = LeaveStatus::APPROVED;
                            }
                        } else {
                            if($leave->quantity > 1 && $leave->leave_type_id == LeaveStatus::SICK){
                                $leave->leave_status = LeaveStatus::PENDING;
                            } else if($leave->quantity > 7 && $leave->leave_type_id == LeaveStatus::LWP){
                                $leave->leave_status = LeaveStatus::PENDING;
                            } else {
                                $leave->leave_status = LeaveStatus::APPROVED;

                            }
                        }
                        if($leave->quantity > 1 && $leave->leave_type_id == LeaveStatus::SICK){
                            $leave->save();
                            Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR approval', 'leave.list'));
                            toastr()->success('Leave Pending.');
                        } else if($leave->quantity > 7 && $leave->leave_type_id == LeaveStatus::LWP){
                            $leave->save();
                            Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR and higher approval', 'leave.list'));
                            toastr()->success('Leave Pending.');
                        } else {
                            DB::beginTransaction();

                            try {
                                if($leave->leave_type_id != LeaveStatus::LWP){
                                    $leaveBalance->decrement('remain', $leave->quantity);
                                }
                                $leaveBalance->increment('used', $leave->quantity);

                                foreach (json_decode($leave->leave_days) as $leaveDay) {
                                    $attendance = Attendance::whereEmployeeId($employee->id)->where('date', $leaveDay)->first();
                                    if ($attendance) {
                                        $attendance->status = $leave->leave_type_id;
                                        $attendance->save();
                                    }
                                }

                                $leave->save();
                                // send notification to the employee for approve leave
                                Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave has been approved', 'leave.list'));
                                toastr()->success('Leave Approved.');
                                DB::commit();
                                // all good
                            } catch (\Exception $e) {
                                DB::rollback();
                                // something went wrong
                                toastr()->error($e->getMessage());
                            }
                        }
                    } else {
                        //dd('sup');
                        $leave->supervisor_approved_by = $request->input('approval_id');
                        $leave->save();
                        // send notification to upper Head of Team
                        //$hot = $teamBelongs->teamLead->userDetails;
                        Notification::send($fetchUpperHeadOfTeam->userDetails, new LeaveApply($leave, $employee->FullName, ' send a leave request.', 'leave.request'));
                        Notification::send($employee->userDetails, new LeaveApply($leave, $teamBelongs->teamLead->FullName, ' approved your leave request and forwarded to '.$fetchUpperHeadOfTeam->FullName.'.', 'leave.request'));
                        toastr()->success('Leave Approved from team leader.');
                    }
                } elseif ($request->input('approval_type') == 'upper_team_leader') {
                    // check attendance table and update leave status
                    //dd('upper');
                    $leave->hot_approved_by = $request->input('approval_id');

                    if($leave->quantity > 1 && $leave->leave_type_id == LeaveStatus::SICK){
                        $leave->leave_status = LeaveStatus::PENDING;
                        $leave->save();
                        Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR approval', 'leave.list'));
                        toastr()->success('Sick Leave is more than 1 day and pending for HR approval.');
                    } else if($leave->quantity > 7 && $leave->leave_type_id == LeaveStatus::LWP){
                        $leave->leave_status = LeaveStatus::PENDING;
                        $leave->save();
                        Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR and higher approval', 'leave.list'));
                        toastr()->success('lwp is more than 7 days and pending for HR and higher approval');
                    } else {

                        DB::beginTransaction();

                        try {
                            $leave->leave_status = LeaveStatus::APPROVED;
                            $leaveBalance->decrement('remain', $leave->quantity);
                            $leaveBalance->increment('used', $leave->quantity);

                            $attendances = Attendance::whereEmployeeId($employee->id)->whereBetween('date', [$leave->strat_date, $leave->end_date])->get();
                            if ($attendances->count()) {
                                foreach ($attendances as $attendance) {
                                    $attendance->status = $leave->leave_type_id;
                                    $attendance->save();
                                }
                            }

                            $leave->save();
                            // send notification to the employee for approve leave
                            Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave has been approved', 'leave.list'));
                            toastr()->success('Leave Approved.');
                            DB::commit();
                            // all good
                        } catch (\Exception $e) {
                            DB::rollback();
                            toastr()->error($e->getMessage());
                        }

                    }

                    // $leave->leave_status = LeaveStatus::APPROVED;

                    // //                    deduct leave from employee leave balance
                    // $leaveBalance->decrement('remain', $leave->quantity);
                    // $leaveBalance->increment('used', $leave->quantity);

                }
            } elseif ($request->input('submit') == "Reject") {
                $leave->leave_status = LeaveStatus::REJECT;
                $leave->remarks = $request->input('remarks');
                $leave->rejected_by = $request->input('approval_id');
                $leave->save();
                // send notification to the employee for reject leave
                Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave request has been rejected', 'leave.list'));

                toastr()->success('Leave Rejected.');
            }
        } else {
            toastr()->error($employee->FullName . ' dose not have required balance.');
        }


        return redirect()->back();
    }


    // leave cancellation
    public function cancelLeave(Request $request)
    {
        $leave = Leave::find($request->id);
        $leave->cancel_request = 1;

        $employee = Employee::find($leave->employee_id);
        $team = $employee->teamMember()->wherePivot('member_type', TeamMemberType::MEMBER)->first();

        if ($leave->save()) {
            // send notification to the Team lead for cancel leave
            Notification::send($team->teamLead->userDetails, new LeaveApply($leave, $employee->FullName, ' send a leave cancel request.', 'leave.request'));
            return response()->json(['success' => 'success', 200]);
        }
        return response()->json(['error' => 'invalid', 401]);
    }

    //
    //
    //    /**
    //    *  @method: leaveApplication
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function saveApplication (Request $request) // Request for leave first step
    //    {
    //       $currentUser = auth()->user()->id; //User Id or From Id
    //       $checkMember = EmployeeTeam::where('employee_id', $currentUser)->first();
    //       if(isset($checkMember)){
    //           $data = [
    //               'employee_id' => $currentUser,
    //               'doj' => $request->input('doj'),
    //               'start_date' => $request->input('start_date'),
    //               'end_date' => $request->input('end_date'),
    //               'quantity' => $request->input('quantity'),
    //               'subject' => $request->input('subject'),
    //               'description' => $request->input('description'),
    //               'leave_location' => $request->input('leave_location'),
    //               'resume_date' => $request->input('resume_date'),
    //               'leave_type' => json_encode($request->input('leave_type'))
    //           ];
    //           $leave = Leave::create($data); // Save leave
    //           $last_leave_id = $leave->id; //Get leave Id
    //           //$workflow_id = Workflow::where('name', 'Leave')->first()->id; // Get workflow ID
    //           $workflow_id = LeaveStatus::LEAVE; // Get workflow ID
    //           $team_workflow_id = $this->findTeamWorkflowId($currentUser, $workflow_id); // Get team_workflow id
    //           $toId = $this->findLeaveToId($team_workflow_id, $currentUser); // To Id
    //           //dd($currentUser);
    //           $approval_process = new ApprovalProcess;
    //           $approval_process->from_id = $currentUser;
    //           $approval_process->to_id = $toId;
    //           $approval_process->processable_id = $last_leave_id;
    //           $approval_process->processable_type = LeaveStatus::PROCESSABLETYPE;
    //           $approval_process->remarks = '';
    //           $approval_process->save(); // save approval process
    //           toastr()->success('Leave successfully created');
    //        }else{
    //            toastr()->success('You are not applicable for leave apply!');
    //        }
    //       return redirect()->route('leave.list');
    //    }
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function findTeamWorkflowId ($userId, $workFlowId) // Get team work flow id
    //    {
    //        $teamId = EmployeeTeam::where('employee_id', $userId)->first()->team_id;
    //        return TeamWorkflow::where('workflow_id', $workFlowId)->where('team_id', $teamId)->first()->id;
    //        // return DB::table('team_workflow')->where('workflow_id', $workFlowId)->where('team_id', $teamId)->first()->id;
    //    }
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function findLeaveToId($team_workflow_id, $user_id) // Who will get this leave for approval
    //    {
    //        $emp = ProcessOrdering::where('team_workflow_id', $team_workflow_id)->where('emp_id', $user_id)->first();
    //        $getOrder = ($emp == null)? 0: $emp->order_number;
    //        $maxOrder  = ProcessOrdering::where('team_workflow_id', $team_workflow_id)->orderBy('id', 'desc')->first()->order_number;
    //        if($getOrder < $maxOrder){
    //            $order = $getOrder + 1;
    //        }else{
    //            $order = $getOrder;
    //        }
    //        $toId = ProcessOrdering::where('order_number', $order)->where('team_workflow_id', $team_workflow_id)->first();
    //        if(!empty($toId)){
    //            return $toId->emp_id;
    //        }else{
    //            return '-1';
    //        }
    //
    //    }
    //
    //
    //    /**
    //     * @method: Leave view by id
    //     * @param : leave id $id
    //     * @return void
    //     *
    //     */
    //    public function leaveView($id)
    //    {
    //        $active = 'leave-view';
    //        $leave = Leave::find($id); //Get this leave data
    //        return view('user.leave.leave-view', compact('active', 'leave', 'id'));
    //    }


    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function leaveApproved (Request $request)
    //    {
    //        $fromUser = auth()->user()->id; //User Id or From Id
    //        $id = $request->input('fld_id');
    //        $remarks = $request->input('remarks');
    //        $submit = $request->input('submit');
    //
    //        $approvalStatus = ($submit === 'Approved')? LeaveStatus::APPROVAL: LeaveStatus::REJECT;
    //
    //        $employeId = Leave::find($id)->employee->id;
    //
    //        $workflow_id = Workflow::where('name', 'Leave')->first()->id;
    //        $team_workflow_id = $this->findTeamWorkflowId($employeId, $workflow_id);
    //
    //        $existUserFromId = ApprovalProcess::where('processable_id', $id)->where('to_id',  $fromUser)->orderBy('id', 'desc')->first();
    //
    //        ApprovalProcess::where('id', $existUserFromId->id)
    //        ->update(['remarks' => $remarks,'status' => $approvalStatus]); // Remark add and status update....
    //
    //        $toId = $this->findLeaveToId($team_workflow_id, $fromUser); // To Id
    //
    //        $toUserId = ($submit === 'Approved') ?  $toId :  $existUserFromId->from_id;
    //
    //        if($toUserId != $fromUser){
    //            $approval_process = new ApprovalProcess;
    //            $approval_process->from_id = $fromUser;
    //            $approval_process->to_id = $toUserId;
    //            $approval_process->processable_id = $id;
    //            $approval_process->processable_type = 'AppLeave';
    //            $approval_process->save();
    //
    //            toastr()->success('Leave Approved successfully created');
    //            return redirect()->route('leave.request');
    //        }else{
    //            $leaveStatus = Leave::where('id', $id)->update(['leave_status' => LeaveStatus::APPROVAL]);
    //
    //            toastr()->success('Leave Approved :) ');
    //            return redirect()->route('leave.request');
    //        }
    //
    //    }
    //
    //

    //    public function requestedApplicationList(Request $request)
    //    {
    //        $userId = auth()->user()->id;
    //        $employeeId = (!empty($request->has('employee_id'))) ? $request->input('employee_id') : null;
    //        $startDate = date_format(date_create($request->input('date_from')), "Y-m-d");
    //        $endDate = date_format(date_create($request->input('date_to')), "Y-m-d");
    //
    //
    //        $active = 'requested-application';
    //        $employees = Employee::all();
    //        return view('user.leave.request-application', compact('active', 'employees'));
    //    }


    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function teamLeaveHistory(Request $request)
    {
        $userId = auth()->user()->employee_id;
        $active = 'team-leave-history';
        $teams = Employee::find($userId)->teamMember()->having('pivot_member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();
        //        dd($userId);
        $employees = Employee::find($userId)->whereHas('teamMember', function ($q) {
            $q->where('member_type', \App\Utils\TeamMemberType::MEMBER);
        })->get();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            return view('user.leave.leave-history', compact('active', 'teams', 'employees'));
        }
        $nextYearTimeStamp = strtotime("1st January Next Year");
        $teamId = $request->input('team');
        $employeeId = $request->input('employee_id');
        $date_from = (!empty($request->input('date_from'))) ? $request->input('date_from') : date('Y-m-d', strtotime('first day of january this year'));
        $date_to = (!empty($request->input('date_to'))) ? $request->input('date_to') : date_format(date_create(date("Y-m-d h:i:sa", $nextYearTimeStamp)), "Y-m-d");


        $employeeCollection = Employee::find($userId)->select('id', 'first_name', 'last_name', 'employer_id')
            ->when($teamId, function ($query) use ($teamId) {
                $query->whereHas('teamMember', function ($query) use ($teamId) {
                    return $query->where('team_id', $teamId);
                });
            })
            ->when($employeeId, function ($query) use ($employeeId) {
                $query->whereHas('teamMember', function ($query) use ($employeeId) {
                    return $query->where('employee_id', $employeeId);
                });
            })
            ->with(['leaves' => function ($query) use ($date_from, $date_to) {
                $query->select(['employee_id', DB::raw('count(*) as numberApplication'), DB::raw('sum(quantity) as totalLeave')])
                    ->where('start_date', '>=', $date_from)->where('end_date', '<=', $date_to)->groupBy('employee_id')->first();
            }])
            ->get();

        return view('user.leave.leave-history', compact('active', 'teams', 'employees', 'employeeCollection'));
    }


    //    /**
    //     *  @method:
    //     *  @param :
    //     *  @return void
    //     *
    //     */
    //    public function allLeaveReportsList (Request $request)
    //    {
    //        $userId = auth()->user()->id;
    //        $employeeId = (!empty($request->has('employee_id')))?$request->input('employee_id'):null;
    //        $startDate = date_format(date_create($request->input('date_from')), "Y-m-d");
    //        $endDate = date_format(date_create($request->input('date_to')), "Y-m-d");
    //
    //
    //        $active = 'requested-application';
    //        $employees = Employee::all();
    //        $processes = Process::all();
    //        $departments = Department::all();
    //        return view('admin.leave.leave-reports', compact('active', 'employees', 'departments', 'processes'));
    //    }
    //
    //
    //
    //    public  function requestedLeaveData()
    //    {
    //        $leaveStatus = LeaveStatus::PENDING;
    //        $currentUser = auth()->user()->id; //User Id or From Id
    //        $result = $this->filterLeaveForOwnUser($currentUser, $leaveStatus);
    //        return $this->filterLeaveForOwnUser($currentUser, $leaveStatus);
    //    }
    //
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function acceptedApplication ()
    //    {
    //        $active = 'accepted-application';
    //        $leaveStatus = LeaveStatus::APPROVAL;
    //        $currentUser = auth()->user()->id; //User Id or From Id
    //        $leaves = $this->filterLeaveForOwnUser($currentUser, $leaveStatus);
    //        return view('user.leave.accepted-application', compact('active', 'leaves'));
    //    }
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //
    //    public function rejectedApplication ()
    //    {
    //        $active = 'rejected-application';
    //        $leaveStatus = LeaveStatus::REJECT;
    //        $currentUser = auth()->user()->id; //User Id or From Id
    //        $leaves = $this->filterLeaveForOwnUser($currentUser, $leaveStatus);
    //        return view('user.leave.rejected-application', compact('active', 'leaves'));
    //    }
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function history ($id)
    //    {
    //        $active = 'leave-history';
    //        $leaves = ApprovalProcess::where('processable_id',$id)->get();
    //        return view('user.leave.history', compact('active', 'leaves'));
    //    }
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function filterLeaveForOwnUser ($userId, $leaveStatus)
    //    {
    //        //        return DB::select("SELECT * from leaves where exists (
    //        //            SELECT 1 from approval_processes where
    //        //            approval_processes.processable_id = leaves.id
    //        //            AND approval_processes.to_id = $userId
    //        //            AND approval_processes.processable_type = 'AppLeave' AND approval_processes.status = $leaveStatus
    //        //            )");
    //        $result = Leave::where('leave_status', $leaveStatus)->get();
    //
    //        $data = $result->map(function($obj){
    //                $obj->employee_id = $obj->employee->employer_id;
    //                $obj->name = $obj->employee->FullName;
    //                $obj->type = $obj->leaveType->name;
    //                $obj->leave_status = trans('leave.status.'.$obj->leave_status);
    //                return $obj;
    //        });
    //        return $data;
    //    }
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function leaveValidationRules (Request $request)
    //    {
    //        $user = auth()->user()->id;
    //        $todate = Carbon::now();
    //        $firstDayOfYear = $todate->year.'-1-1';
    //        $leaveBalance = LeaveBalance::where('employee_id', $user)->where('year', $todate->year)->first();
    //
    //        if(empty($leaveBalance)){
    //            return 'no';
    //        }
    //
    //        $quantity = $request->input('quantity');
    //        $leaveType = $request->input('type');
    //        $selectColumnName = 'remain_'.strtolower(SetLeave::where('id', $leaveType)->first()->name).'_leave';
    //        $remainQuantity = $leaveBalance->{$selectColumnName};
    //        $permanentOrProbationDate = (isset($leaveBalance->permanent_doj))?$leaveBalance->permanent_doj:$leaveBalance->probation_start_date;
    //
    //
    //        switch ($leaveType) {
    //            case "1":
    //                $result = ($quantity < $remainQuantity)?'yes':'no';
    //                return $result;
    //                break;
    //            case "2":
    //                $result = ($quantity < $remainQuantity)?'yes':'no';
    //                return $result;
    //                break;
    //            case "3":
    //                $selectedDate = max($permanentOrProbationDate, $firstDayOfYear); //select max value
    //                $cusDate = Carbon::parse($selectedDate); //custing date
    //                $totalDays = $cusDate->diffInDays($todate); //count day form joing date or first day of year
    //                $totalRemainLeave = round($this->getTotalRemainLeave($totalDays, $leaveBalance,$leaveType));
    //                $result = ($totalRemainLeave > $quantity)? 'yes':'no';
    //                return $result;
    //                break;
    //            case "5":
    //                $result = ($quantity < $remainQuantity)?'yes':'no';
    //                return $result;
    //                break;
    //            case "6":
    //                $result = ($quantity < $remainQuantity)?'yes':'no';
    //                return $result;
    //                break;
    //        }
    //
    //    }
    //
    //
    //    /**
    //    *  @method:
    //    *  @param :
    //    *  @return void
    //    *
    //    */
    //    public function getTotalRemainLeave($totalDays, $balance,$type)
    //    {
    //        $databaseMap = [
    //            LeaveStatus::SickLeave => 'remain_sick_leave',
    //            LeaveStatus::EarnLeave => 'remain_earned_leave',
    //            LeaveStatus::CasualLeave => 'remain_casual_leave',
    //            LeaveStatus::MaternityLeave => 'remain_maternity_leave',
    //            LeaveStatus::PaternityLeave => 'remain_paternity_leave',
    //            LeaveStatus::LwpLeave => 'remain_lwp_leave'
    //        ];
    //
    //        $totalLeave = 0;
    //        foreach($databaseMap as $key => $column) {
    //                if(isset($type[$key]) == 'total_casual_leave'){
    //                    $totalLeave += ($totalDays / 30.42) * ($balance->remain_earned_leave)/12;
    //
    //                $totalLeave += $balance->$column;
    //            }
    //        }
    //
    //        return $totalLeave;
    //    }


    //    public function teamLeaveStatus($id = null)
    //    {
    //        $active = 'leave-list';
    //        $userId = ($id == null) ? auth()->user()->employee_id : $id;
    //        $leaveBalance = LeaveBalance::where('employee_id', $userId)->where('year', date('Y'))->first();
    //        $leaves = Leave::where('employee_id', $userId)->get();
    //        $employees = Employee::all();
    //        return view('user.leave.team-leave-status', compact('active', 'leaves', 'leaveBalance', 'employees'));
    //    }


    // public function teamLeaveStatus(Request $request)
    // {
    //     $active = 'team-leave-status';
    //     $userId = auth()->user()->employee_id;
    //     $teams = Employee::find($userId)->teamMember()->having('pivot_member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();

    //     $employees = Employee::find($userId)->whereHas('teamMember', function ($q) {
    //         $q->where('member_type', \App\Utils\TeamMemberType::MEMBER);
    //     })->get();

    //     $requestCheck = $request->all();
    //     if (!$requestCheck) {
    //         return view('user.leave.team-leave-status', compact('active', 'teams', 'employees'));
    //     }

    //     $nextYearTimeStamp = strtotime("1st January Next Year");

    //     $teamId = $request->input('team');

    //     $employeeId = $request->input('employee_id');
    //     $date_from = (!empty($request->input('date_from'))) ? $request->input('date_from') : date('Y-m-d', strtotime('first day of january this year'));
    //     $date_to = (!empty($request->input('date_to'))) ? $request->input('date_to') : date_format(date_create(date("Y-m-d h:i:sa", $nextYearTimeStamp)), "Y-m-d");

    //     $queryLeave = DB::table('leaves')->rightJoin('employees', 'leaves.employee_id', 'employees.id');
    //     $queryLeave->select([
    //         'employee_id',
    //         'employees.employer_id',
    //         'employees.first_name',
    //         'employees.last_name',
    //         DB::raw("SUM(CASE WHEN leave_type_id = 1 THEN quantity ELSE 0 END) Casual"),
    //         DB::raw("SUM(CASE WHEN leave_type_id = 2 THEN quantity ELSE 0 END) Sick"),
    //         DB::raw("SUM(CASE WHEN leave_type_id = 3 THEN quantity ELSE 0 END) Earned"),
    //         DB::raw("SUM(CASE WHEN leave_type_id = 4 THEN quantity ELSE 0 END) Maternity"),
    //         DB::raw("SUM(CASE WHEN leave_type_id = 5 THEN quantity ELSE 0 END) Paternity"),
    //         DB::raw("SUM(CASE WHEN leave_type_id = 6 THEN quantity ELSE 0 END) LWP"),
    //     ]);
    //     $queryLeave->whereRaw("start_date >= '{$date_from}' AND end_date <= '{$date_to}'");
    //     $queryLeave->groupBy('employee_id');

    //     $query = DB::table('teams')->join('employee_team', function ($join) use ($teamId, $employeeId) {
    //         $join->on('teams.id', 'employee_team.team_id');
    //         $join->where("employee_team.member_type", TeamMemberType::MEMBER)
    //             ->when($teamId, function ($query) use ($teamId) {
    //                 $query->where('employee_team.team_id', $teamId);
    //             })
    //             ->when($employeeId, function ($query) use ($employeeId) {
    //                 $query->where('employee_team.employee_id', $employeeId);
    //             });
    //     });

    //     $query->join(DB::raw("(" . $queryLeave->toSql() . ") tls "), "tls.employee_id", "employee_team.employee_id");
    //     //        dd($query->toSql());
    //     $teamLeaveStatus = $query->select("tls.employee_id as id", DB::raw("(tls.Casual+tls.Sick+tls.Earned+tls.Maternity+tls.Paternity+tls.LWP) as totalLeave"), "tls.employer_id as employer_id", 'first_name', 'last_name', "teams.name as team", "Casual", "Sick", "Earned", "Maternity", "Paternity", "LWP")->get();
    //     //        dd($teamLeaveStatus);
    //     return view('user.leave.team-leave-status', compact('active', 'teams', 'employees', 'teamLeaveStatus'));
    // }

    public function teamLeaveStatus(Request $request)
    {
        $active = 'team-leave-status';
        $userId = auth()->user()->employee_id;
        $teamId = $request->input('team');
        $leave_types = LeaveType::all();
        $employees = EmployeeTeam::where('team_id', $teamId)->get();
        $teams = Employee::find($userId)->teamMember()->having('pivot_member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();

        // $leaveStatus = [];
        // foreach($employees as $employee){
        //     $typeStatus = [];
        //     foreach($leave_types as $leave_type){
        //         if($leave_type->short_code != 'PL' && $leave_type->short_code != 'ML'){
        //             $typeStatus[$leave_type->short_code] = 0;
        //         }
        //     }
        // }

        $requestCheck = $request->all();
        if (!$requestCheck) {
            return view('user.leave.team-leave-status', compact('active', 'teams', 'employees', 'leave_types'));
        }

        $nextYearTimeStamp = strtotime("1st January Next Year");

        $teamId = $request->input('team');
        return view('user.leave.team-leave-status', compact('active', 'teams', 'employees', 'leave_types'));
    }


    public function getEmployeeListByTeamLeadOrSuperVisor(Request $request)
    {
        $id = $request->input('id');
        $employees = Employee::select('id', 'employer_id', 'first_name', 'last_name')->whereHas('teamMember', function ($q) use ($id) {
            $q->where('member_type', \App\Utils\TeamMemberType::MEMBER)->where('team_id', $id);
        })->get();

        echo json_encode($employees);
    }

    public function checkBridge(Request $request) {
        return $request->all();
    }
}