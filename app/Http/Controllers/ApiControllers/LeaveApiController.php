<?php

namespace App\Http\Controllers\ApiControllers;

use App\Attendance;
use App\Employee;
use App\Leave;
use App\LeaveBalance;
use App\LeaveDocument;
use App\LeaveReason;
use App\LeaveType;
use App\Notifications\LeaveApply;
use App\Services\EarnLeaveService;
use App\Services\LeaveService;
use App\Utils\AttendanceStatus;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scopes\DivisionCenterScope;
use Illuminate\Support\Facades\Notification;
use Validator;

class LeaveApiController extends BaseController
{
    public function leaveBalances($id, $year=null){
        $employee = Employee::withoutGlobalScopes()->whereId($id)->with(['employeeJourney'])->first();
        $year = date('Y');
        $earnLeaveService = new EarnLeaveService($employee);
        $LeaveBalances = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', $year)
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', '!=', LeaveStatus::MATERNITY)
            ->where('leave_type_id', '!=', LeaveStatus::PATERNITY)
            ->get()
            ->map(function ($item) use ($employee, $earnLeaveService){
                if($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PROBATION){
                    if ($item->leave_type_id == LeaveStatus::CASUAL){
                        $item->total = (string) $earnLeaveService->proratedCasualLeave();
                        $item->remain = (string) $earnLeaveService->proratedCasualLeaveRemain();
                    }elseif($item->leave_type_id == LeaveStatus::SICK){
                        $item->total = (string) $earnLeaveService->proratedSickLeave();
                        $item->remain = (string) $earnLeaveService->proratedSickLeaveRemain();
                    }
                } else if($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT){
                    if($item->leave_type_id == LeaveStatus::EARNED){
                        $total = $item->total + $earnLeaveService->calculateEarnLeaveBalance(); 
                        $remain = $total - $item->used;
                        $item->total = (string) number_format($total, 1);
                        $item->remain = (string) number_format($remain, 1);
                    }
                }
                if($item->leave_type_id == LeaveStatus::LWP){
                    $item->total = (string) number_format(0, 1);
                    $item->remain = (string) number_format(0, 1);
                }

                return $item;
            });
        return $this->sendResponse($LeaveBalances, 'Leave balances retrieved successfully.');
    }

    public function leaveTypes(){
        $leaveTypes = LeaveType::all()->map(function ($item){
            if($item->short_code == 'EL') {
                $item->short_code = 'AL';
            }
            return $item;
        });
        return $this->sendResponse($leaveTypes, 'Leave types retrieved successfully.');
    }

    public function leaveReasons(){
        $leaveReasons = LeaveReason::all();
        //return response()->json($leaveReasons, 200);
        return $this->sendResponse($leaveReasons, 'Leave reasons retrieved successfully.');
    }

    public function leaveLists($id){
        $leaves = Leave::where('employee_id', $id)
            ->whereHas('employee', function ($q){
                $q->withoutGlobalScopes();
            })
            ->latest()->paginate(10);
        //return response()->json($leaves, 206);
        return $this->sendResponse($leaves, 'Leave retrieved successfully.');
    }

    public function leaveApply(Request $request){
        // $request->input('end_date') = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        // return $request;

        //return $this->sendResponse( $request->all(), 'working');
        $today = Carbon::now();
        $canApply = $today->subDays(15)->format('Y-m-d');

        $employeeID = $request->input('employee_id');
        $employee = Employee::whereId($employeeID)->withoutGlobalScopes()->with('employeeJourney')->first();

        $startDate = Carbon::create($request->input('start_date'));
        $endDate = Carbon::create($request->input('end_date'));
        //$quantity = ($request->input('half_day')) ? 0.5 : $startDate->diffInDays($endDate) + 1;
        $teamBelongs = $employee->teamMember()->withoutGlobalScopes()->wherePivot('member_type', TeamMemberType::MEMBER)->first();

        $isBridge = false;
        $day_off_start = $employee->fixedOfficeTime->where('is_offday', 1)->where('day', Carbon::parse($startDate)->format('l'));
        // return $day_off_start->count();
        if($day_off_start->count()){
            //toastr()->error("Start date is off day!");
            return $this->sendError('Leave not applied.', "Start date is off day!");
        }
        $leaveService = new LeaveService($employee, $request);
        //$leaveCheck = $leaveService->leaveCheck($startDate, $endDate, $isBridge);
        $leaveCheck = $leaveService->leaveCheck($startDate, $endDate);
        $checkLeaveIsUsable = $leaveService->checkLeaveIsUsable($leaveCheck['count']);
        
        // return $leaveCheck['count'];

        if($checkLeaveIsUsable){
            return $this->sendError('Leave not applied.', "You Can not Apply Leave.");
        }
        if($leaveCheck['redirectBack']){
            return $this->sendError('Leave not applied.', "You Can not Apply Leave.");
        }

        // return $checkLeaveIsUsable;


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
                    //toastr()->error("You don't have sufficient balance.");
                    return $this->sendError('Leave not applied.', "You don't have sufficient balance.");
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
            return $this->sendError('Validation Error.', $validator->errors());
        }



        //check if already applied for leave.
        if ($leaveService->appliedLeaveCheck($startDate, $endDate)) {
            //toastr()->error('You have already applied leave for these days.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            //return redirect()->back()->withInput();
            return $this->sendError('Apply Error.', 'You have already applied leave for these days.');
        }

        // check if he/she belongs to any team as a member
        if ($teamBelongs) {
            $leaveRuleId = $teamBelongs->leaveRule->id;
        } else {
            //toastr()->error("You don't seem to belong to any team. Please contact with your Supervisor or HR.");
            //return redirect()->back();
            return $this->sendError('Apply Error.', "You don't seem to belong to any team. Please contact with your Supervisor or HR.");

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
            $earnLeaveService = new EarnLeaveService($employee);
            //$leaveBalance = $earnLeaveService->earnLeaveRemain();
            $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($quantity);
            if ($earnLeaveApplyPolicy['can_apply']) {
                $leave->from_forwarded_el = ($earnLeaveApplyPolicy['from_forwarded_el']) ? $earnLeaveApplyPolicy['from_forwarded_el'] : null; // leave applied from forwarded leave balance
            }
        }



        if ($leaveBalance || $earnLeaveApplyPolicy['can_apply']) {
            if($isBridge == false){
                foreach ($leaveCheck['days'] as $leaveDay) {
                    $attendance = Attendance::whereEmployeeId($employeeID)->where('date', $leaveDay)->first();
                    if ($attendance) {
                        if ($attendance->status == AttendanceStatus::DAYOFF || $attendance->status == AttendanceStatus::HOLIDAY) {
                            //toastr()->error('You are applying leave on "Day Off" or "Holiday".');
                            //return redirect()->back();
                            return $this->sendError('Apply Error.', 'You are applying leave on "Day Off" or "Holiday".');
                        } elseif ($attendance->status == AttendanceStatus::PRESENT) {
                            //toastr()->error('You were present on ' . $attendance->date, 'Sorry!');
                            //return redirect()->back();
                            return $this->sendError('Apply Error.', 'You were present on ' . $attendance->date, 'Sorry!');
                        }
                    }
                }
            }

            // supervisors
            $fetchSupervisors = $teamBelongs->employees()->withoutGlobalScopes()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get();
            $fetchHeadOfTeam = $teamBelongs->employees()->withoutGlobalScopes()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->first();


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

            //toastr()->success('Leave successfully applied');
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
            //toastr()->success('Leave application sent successfully.');
        } else {
            //toastr()->error('You do not have required balance.');
            //return redirect()->back();
            return $this->sendError('Apply Error.','You do not have required balance.');
        }

        //return redirect()->route('leave.list');
        return $this->sendResponse($leave->toArray(), 'Leave applied successfully.');
    }


    public function leaveRequestLists($empId){
        $employee = Employee::whereId($empId)->withoutGlobalScopes()->first();
        $leadingTeams = $employee->teamMember()->withoutGlobalScopes()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();
        $leavesToHot = [];
        //return $this->sendResponse($this->getTeamMembersId($leadingTeams), 'Leave request lists retrieved successfully.');
        if ($leadingTeams) {
            $employeeIds = $this->getTeamMembersId($leadingTeams);
            $leadingTeamsEmployeeIds = $employeeIds["team-members"];
            $childTeamsEmployeeIds = $employeeIds["child-team-members"];

            $leavesToHot = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)->whereNull('supervisor_approved_by')->whereNull('hot_approved_by')->whereNull('rejected_by')->with(['employee' => function($q){
                $q->select('id','employer_id', 'first_name','last_name','gender')->withoutGlobalScope(DivisionCenterScope::class);
            }])->get();
            $leavesToUpperHot = Leave::whereIn('employee_id', $childTeamsEmployeeIds)->whereNotNull('supervisor_approved_by')->whereNull('hot_approved_by')->whereNull('rejected_by')->with(['employee' => function($q){
                $q->select('id','employer_id', 'first_name','last_name','gender')->withoutGlobalScope(DivisionCenterScope::class);
            }])->get();
            $leaveCancelRequests = Leave::whereIn('employee_id', $leadingTeamsEmployeeIds)
                ->whereNotNull('hot_approved_by')
                ->where('leave_status', LeaveStatus::APPROVED)
                ->whereNull('rejected_by')                
                ->where('cancel_request', 1)
                ->with(['employee' => function($q){
                    $q->select('id','employer_id', 'first_name','last_name','gender')->withoutGlobalScope(DivisionCenterScope::class);
                }])
                ->get();
        }
        return $this->sendResponse(['leaveToHot' => $leavesToHot, 'leavesToUpperHot' => $leavesToUpperHot, 'leaveCancelRequests' => $leaveCancelRequests], 'Leave request lists retrieved successfully.');
    }

    public function getTeamMembersId($teams)
    {
        $teamMembers = [];
        $childTeamMembers = [];
        foreach ($teams as $team) {
            //return $this->sendResponse($team->children()->withoutGlobalScopes()->get(), 'Leave request lists retrieved successfully.');
            $teamMembers[] = $team->employees()->withoutGlobalScopes()->select('employees.id')->wherePivot('member_type', TeamMemberType::MEMBER)->get();
            if ($team->children()->withoutGlobalScopes()->count()) {
                foreach ($team->children()->withoutGlobalScopes()->get() as $childTeam) {
                    $childTeamMembers[] = $childTeam->employees()->withoutGlobalScopes()->select('employees.id')->wherePivot('member_type', TeamMemberType::MEMBER)->get();
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


    public function leaveApproval(Request $request)
    {
        $leave = Leave::find($request->input('leave_id'));
        $employee = Employee::whereId($leave->employee_id)->withoutGlobalScopes()->with(['employeeJourney'])->first();
        $responseMessages = [];
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
                    //toastr()->success('Leave Approved.');
                    $responseMessages = ['successMessage' => 'Leave Approved.'];

                    DB::commit();
                    // all good
                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    //toastr()->error($e->getMessage());
                    $responseMessages = ['errorMessage' => $e->getMessage()];
                }

            } else {
                //toastr()->error($employee->FullName . ' dose not have required balance.');
                $responseMessages = ['errorMessage' => $employee->FullName . ' dose not have required balance.'];
            }
            //return redirect()->back();
            return $this->sendResponse($leave, $responseMessages);

        }
        $earnLeaveApplyPolicy = null;
        if ($leave->leave_type_id == LeaveStatus::EARNED) {
            $earnLeaveService = new EarnLeaveService($employee);
            $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($leave->quantity);
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



        $teamBelongs = $employee->teamMember()->withoutGlobalScopes()->wherePivotIn('member_type', [TeamMemberType::MEMBER])->first();
        $fetchUpperHeadOfTeam = ($teamBelongs->parent_id) ? $teamBelongs->parent()->withoutGlobalScopes()->first()->teamLead()->withoutGlobalScopes()->first() : null;

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
                            if ($leaveBalance && $leave->from_forwarded_el && $earnLeaveApplyPolicy['can_apply']) {
                                DB::beginTransaction();

                                try {
                                    $earnForwardedBalance = $employee->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first();
                                    $earnForwardedBalance->decrement('forwarded_balance', $leave->from_forwarded_el);
                                    $earnForwardedBalance->decrement('total_balance', $leave->from_forwarded_el);
                                    $leaveBalance->decrement('remain', $leave->quantity - $leave->from_forwarded_el);
                                    $leaveBalance->increment('used', $leave->quantity - $leave->from_forwarded_el);

                                    DB::commit();
                                    // all good
                                } catch (\Exception $e) {
                                    DB::rollback();

                                }

                            } elseif ($leaveBalance && $leave->from_forwarded_el == null && $earnLeaveApplyPolicy['can_apply']) {
                                $leaveBalance->decrement('remain', $leave->quantity);
                                $leaveBalance->increment('used', $leave->quantity);
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
                            //toastr()->success('Leave Pending.');
                            $responseMessages = ['successMessage' => 'Leave Pending.'];
                        } else if($leave->quantity > 7 && $leave->leave_type_id == LeaveStatus::LWP){
                            $leave->save();
                            Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR and higher approval', 'leave.list'));
                            //toastr()->success('Leave Pending.');
                            $responseMessages = ['successMessage' => 'Leave Approved.'];

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
                                //toastr()->success('Leave Approved.');
                                $responseMessages = ['successMessage' => 'Leave Approved.'];
                                DB::commit();
                                // all good
                            } catch (\Exception $e) {
                                DB::rollback();
                                // something went wrong
                                //toastr()->error($e->getMessage());
                                $responseMessages = ['errorMessage' => $e->getMessage()];
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
                        //toastr()->success('Leave Approved from team leader.');
                        $responseMessages = ['successMessage' => 'Leave Approved from team leader.'];
                    }
                } elseif ($request->input('approval_type') == 'upper_team_leader') {
                    // check attendance table and update leave status
                    //dd('upper');
                    $leave->hot_approved_by = $request->input('approval_id');

                    if($leave->quantity > 1 && $leave->leave_type_id == LeaveStatus::SICK){
                        $leave->leave_status = LeaveStatus::PENDING;
                        $leave->save();
                        Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR approval', 'leave.list'));
                        //toastr()->success('Sick Leave is more than 1 day and pending for HR approval.');
                        $responseMessages = ['successMessage' => 'Sick Leave is more than 1 day and pending for HR approval.'];
                    } else if($leave->quantity > 7 && $leave->leave_type_id == LeaveStatus::LWP){
                        $leave->leave_status = LeaveStatus::PENDING;
                        $leave->save();
                        Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave is pending for HR and higher approval', 'leave.list'));
                        //toastr()->success('lwp is more than 7 days and pending for HR and higher approval');
                        $responseMessages = ['successMessage' => 'lwp is more than 7 days and pending for HR and higher approval'];
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
                            //toastr()->success('Leave Approved.');
                            $responseMessages = ['successMessage' => 'Leave Approved.'];
                            DB::commit();
                            // all good
                        } catch (\Exception $e) {
                            DB::rollback();
                            //toastr()->error($e->getMessage());
                            $responseMessages = ['errorMessage' => $e->getMessage()];
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

                //toastr()->success('Leave Rejected.');
                $responseMessages = ['successMessage' => 'Leave Rejected.'];
            }
        } else {
            //toastr()->error($employee->FullName . ' dose not have required balance.');
            $responseMessages = ['errorMessage' => $employee->FullName . ' dose not have required balance.'];
        }

        return $this->sendResponse($leave, $responseMessages);
    }
}
