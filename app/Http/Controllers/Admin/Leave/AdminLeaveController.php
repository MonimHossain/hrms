<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Attendance;
use App\Charts\AdminChart;
use App\Department;
use App\EmploymentType;
use App\Http\Controllers\User\LeavesController;
use App\Leave;
use App\LeaveBalanceSetting;
use App\Notifications\LeaveApply;
use App\Process;
use App\ProcessSegment;
use App\Roster;
use App\Services\EarnLeaveService;
use App\Utils\AttendanceStatus;
use App\Team;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\SetLeave;
use App\EmployeeJourney;
use App\LeaveBalance;
use App\LeaveDocument;
use App\LeaveReason;
use App\LeaveType;
use App\Scopes\DivisionCenterScope;
use App\Services\LeaveService;
use DB;
use Validator;
use Illuminate\Support\Facades\Notification;
use PDF;


class AdminLeaveController extends Controller
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

    // TODO Leave Dashboard
    public function leaveDashboard(Request $request)
    {
        $active = 'leave-dashboard';
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');
        // $employee = Employee::select('id', 'first_name', 'last_name', 'gender')->get();

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

        $leaveAll = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->with(['employee' => function ($q) {
                $q->withoutGlobalScope(DivisionCenterScope::class);
            }])
            ->get();

        $totalSl = $leaveAll->where('leave_type_id', LeaveStatus::SICK)
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            }) ?? 0;

        $totalCl = $leaveAll->where('leave_type_id', LeaveStatus::CASUAL)
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            }) ?? 0;

        $totalEl = $leaveAll->where('leave_type_id', LeaveStatus::EARNED)
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            }) ?? 0;

        $totalOther = $leaveAll->whereNotIn('leave_type_id', [LeaveStatus::SICK, LeaveStatus::CASUAL, LeaveStatus::EARNED])
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            }) ?? 0;


        $totalLeave = $leaveAll
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            });


        // Gender ration
        $maleLeave = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->whereHas('employee', function ($q) {
                $q->where('gender', 'Male');
            })
            ->with('employee')
            ->get()
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            });

        $femaleLeave = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->whereHas('employee', function ($q) {
                $q->where('gender', 'Female');
            })
            ->with('employee')
            ->get()
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            });


        $genderRatioData = [
            'Male' => ($totalLeave) ? number_format((($maleLeave ?? 0) / $totalLeave) * 100, 2) : 0,
            'Female' => ($totalLeave) ? number_format((($femaleLeave ?? 0) / $totalLeave) * 100, 2) : 0
        ];
        $genderRatio = new AdminChart();
        // $genderRatio->displayAxes(false);
        $genderRatio->options([
            'showAllTooltips' => true
        ]);
        $genderRatio->labels(['Male', 'Female']);
        $genderRatio->dataset('Gender', 'pie', [$genderRatioData['Male'], $genderRatioData['Female']])->color($borderColors)->backgroundcolor($fillColors);

        // Dhk vs Ctg Leave
        $dhkLeave = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->whereHas('employee', function ($q) {
                return $q->dhakaCenter();
            })
            ->get()
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            });

        $ctgLeave = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->whereHas('employee', function ($q) {
                return $q->ctgCenter();
            })
            ->get()
            ->reduce(function ($data, $item) {
                return $data + $item->quantity;
            });

        $dhkVsCtgData = [
            'dhkLeave' => ($totalLeave) ? number_format((($dhkLeave ?? 0) / $totalLeave) * 100, 2) : 0,
            'ctgLeave' => ($totalLeave) ? number_format((($ctgLeave ?? 0) / $totalLeave) * 100, 2) : 0
        ];
        $dhkVsCtg = new AdminChart();
        // $dhkVsCtg->displayAxes(false);
        $dhkVsCtg->options([
            'showAllTooltips' => true
        ]);
        $dhkVsCtg->labels(['DHK', 'CTG']);
        $dhkVsCtg->dataset('Center', 'pie', [$dhkVsCtgData['dhkLeave'], $dhkVsCtgData['ctgLeave']])->color($borderColors)->backgroundcolor($fillColors);

        // department wise leave report
        $departments = Department::all();
        foreach ($departments as $dept) {
            $employees = Employee::select('id')->whereHas('departmentProcess', function ($q) use ($dept) {
                $q->where('department_id', $dept->id);
            })->get();
            $employeeIds = ($employees->count()) ? $employees->reduce(function ($ids, $employee) {
                $ids[] = $employee->id;
                return $ids;
            }) : null;
            ($employeeIds && count($employeeIds)) ? $leaves = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])->whereIn('employee_id', $employeeIds)->whereMonth('start_date', $month)->whereYear('start_date', $year)->where('leave_status', LeaveStatus::APPROVED)->get() : $leaves = null;

            $departmentWistLeave[] = [
                'name' => $dept->name,
                'leaves' => ($leaves) ? $leaves->reduce(function ($data, $item) {
                    return $data + $item->quantity;
                }) ?? 0 : 0
            ];
        }
        $departmentHeadCount = new AdminChart();
        $departmentHeadCount->displayAxes(true);
        $departmentHeadCount->labels(array_column($departmentWistLeave, 'name'));
        $departmentHeadCount->dataset('Leave', 'bar', array_column($departmentWistLeave, 'leaves'))->color($borderColors)->backgroundcolor($fillColors);


        // Leave reason wise report
        $leaveReasons = LeaveReason::all();
        foreach($leaveReasons as $reason){
            $leaves = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])->where('leave_reason_id', $reason->id)->whereMonth('start_date', $month)->whereYear('start_date', $year)->where('leave_status', LeaveStatus::APPROVED)->get();
            $leaveReasonWiseData[] = [
                'reason' => $reason->leave_reason,
                'leaves' => ($leaves) ? $leaves->reduce(function ($data, $item) {
                    return $data + $item->quantity;
                }) ?? 0 : 0
            ];
        }
        $leaveReason = new AdminChart();
        $leaveReason->displayAxes(true);
        $leaveReason->labels(array_column($leaveReasonWiseData, 'reason'));
        $leaveReason->dataset('Leave Reason', 'bar', array_column($leaveReasonWiseData, 'leaves'))->color($borderColors)->backgroundcolor($fillColors);


        return view(
            'admin.leave.dashboard-leave',
            compact(
                'active',
                'month',
                'year',
                'totalSl',
                'totalCl',
                'totalEl',
                'totalOther',
                'genderRatio',
                'dhkVsCtg',
                'departmentHeadCount',
                'leaveReason'
            )
        );
    }

    public function reportView(Request $request)
    {
        $active = 'Leave-report';
        $departments = Department::all();
        $processes = Process::all();
        $roster = Roster::all();
        $leave = array();
        $employeeCollection = array();
        
        if (!$request->all()) {
            return view('admin.leave.report', compact('active', 'departments', 'processes', 'leave', 'employeeCollection'));
        }
        $nextYearTimeStamp = strtotime("1st January Next Year");

        $date_from = (!empty($request->input('date_from'))) ? $request->input('date_from') : date('Y-m-d', strtotime('first day of january this year'));

        $employee = ($request->input('employer_id')) ? Employee::where('employer_id', $request->input('employer_id'))->first() : null;

        if (isset($employee->id)) {
            $employeeId = $employee->id;
            $leave = LeaveBalance::where('employee_id', $employeeId)->where('employment_type_id', $employee->employeeJourney->employment_type_id)->where('year', $date_from)->get();
            $employeeCollection = Employee::select('id', 'first_name', 'last_name', 'employer_id')
                ->where('id', $employeeId)                
                ->with(['leaves' => function ($query) use ($date_from) {
                    $query->select(['employee_id', DB::raw('count(leaves.id) as numberApplication'), DB::raw('sum(leaves.quantity) as totalLeave')])
                        ->whereYear('start_date', '=', $date_from)->groupBy('employee_id');
                }])
                ->paginate(10);
        }
        return view('admin.leave.report', compact('active', 'departments', 'processes', 'employeeCollection', 'leave', 'employee'));
    }


    public function adminLeaveApplication(Request $request)
    {
        $active = 'leave-application-create';
        $employee_id = null;
        $leaveTypes = null;
        $employee = null;
        $maternity_leave = null;
        $paternity_leave = null;
        $employment_type_id = null;
        $request_type = null;
        $leaveBalanceSettings = null;
        $balances = null;
        $leaveBalances = null;
        $leaveReasons = LeaveReason::all();

        $employee_id = $request->input('employee_id');
        $employee = Employee::find($employee_id);

        if ($request->has('employee_id') && $request->input('submit') == 'apply_wild_leave') {
            $employment_type_id = $employee->employeeJourney->employment_type_id;

            if (!$employee->leaveBalances->where('year', date('Y'))->where('employment_type_id', $employment_type_id)->count()) {
                toastr()->Error('Leave is not generated for ' . $employee->FullName);
                return redirect()->back();
            }



            $maternity_leave = LeaveBalanceSetting::where('employment_type_id', $employment_type_id)->where('leave_type_id', LeaveStatus::MATERNITY)->first();
            $maternity_leave = ($maternity_leave) ? $maternity_leave->quantity : null;

            $paternity_leave = LeaveBalanceSetting::where('employment_type_id', $employment_type_id)->where('leave_type_id', LeaveStatus::PATERNITY)->first();
            $paternity_leave = ($paternity_leave) ? $paternity_leave->quantity : null;
            $request_type = $request->input('submit');

            $leaveTypes = LeaveBalance::where('employee_id', $employee_id)
                ->where('year', date('Y'))
                ->where('employment_type_id', $employment_type_id)
                ->where('remain', '>', 0)
                //->where('is_usable', 1)
                ->get();
            $balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
                ->where('employment_type_id', $employment_type_id)
                ->select('leave_type_id', 'total', 'used', 'remain')
                ->get();

            $leaveBalances = LeaveBalance::where('employee_id', $employee_id)
                ->where('year', date('Y'))
                ->where('employment_type_id', $employment_type_id)
                ->get();
        } else if ($request->has('employee_id') && $request->input('submit') == 'generate_leave_balance') {
            $employment_type_id = $employee->employeeJourney->employment_type_id;
            $leaveBalanceSettings = LeaveBalanceSetting::where('employment_type_id', $employment_type_id)->get();
            $request_type = $request->input('submit');
            $balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
                ->where('employment_type_id', $employment_type_id)
                ->select('leave_type_id', 'total', 'used', 'remain')
                ->get();

            $leaveBalances = LeaveBalance::where('employee_id', $employee_id)
                ->where('year', date('Y'))
                ->where('employment_type_id', $employment_type_id)
                ->get();
        }

        return view('admin.leave.leave-application', compact('active', 'leaveTypes', 'balances', 'leaveReasons', 'leaveBalances', 'request_type', 'leaveBalanceSettings', 'employee_id', 'employee', 'maternity_leave', 'paternity_leave'));
    }


    public function leaveApproval(Request $request)
    {
        // dd($request->all());
        $leave = Leave::find($request->input('leave_id'));
        $employee = Employee::find($leave->employee_id);

        $earnLeaveApplyPolicy = null;
        if ($leave->leave_type_id == LeaveStatus::EARNED) {
            $earnLeaveService = new EarnLeaveService($employee);
            $earnLeaveApplyPolicy = $earnLeaveService->applyEarnLeave($leave->quantity);
            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
               ->where('year', date('Y'))
               ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
               ->where('leave_type_id', $leave->leave_type_id)
               ->where('remain', '>=', $leave->quantity)
               ->first();
        }
        else if($leave->leave_type_id == LeaveStatus::LWP){
            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->first();
        } else {
            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->where('remain', '>=', $leave->quantity)
            ->first();
        }

        $teamBelongs = $employee->teamMember()->wherePivotIn('member_type', [TeamMemberType::MEMBER])->first();
        $fetchUpperHeadOfTeam = ($teamBelongs->parent_id) ? $teamBelongs->parent->teamLead : null;


        if ($leaveBalance || $earnLeaveApplyPolicy['can_apply'] || $leave->leave_type_id == LeaveStatus::LWP) {
            if ($request->input('submit') == "Approved") {

                if ($request->input('approval_type') == 'hr') {

                    // check attendance table and update leave status
                    $attendances = Attendance::whereEmployeeId($employee->id)->whereBetween('date', [$leave->strat_date, $leave->end_date])->get();
                    if ($attendances->count()) {
                        foreach ($attendances as $attendance) {
                            $attendance->status = $leave->leave_type_id;
                            $attendance->save();
                        }
                    }
                    $leave->hr_approved_by = $request->input('approval_id');
                    $leave->leave_status = LeaveStatus::APPROVED;
                    if($leave->leave_type_id == LeaveStatus::LWP){
                        $leaveBalance->increment('used', $leave->quantity);
                    } else {
                        $leaveBalance->decrement('remain', $leave->quantity);
                        $leaveBalance->increment('used', $leave->quantity);
                    }
                    $leave->save();
                    // send notification to the employee for approve leave
                    Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave has been approved', 'leave.list'));
                    toastr()->success('Leave Approved.');
                } else if($request->approval_type == 'HOD'){

                    $leave->lwp_approved_by = $request->input('lwp_approved_by');
                    $leave->leave_status = LeaveStatus::PENDING;
                    $leave->save();
                    // send notification to the employee for approve leave
                    Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your LWP request is now pending for HR approval', 'leave.list'));
                    toastr()->success('LWP request is now pending for HR approval.');
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

    public function leaveView($id, $approval_type = null, $approval_id = null)
    {
        $active = 'leave-view';
        $leave = Leave::find($id); //Get this leave data
        $type="hr";

        // Leave Balance
        $leave_type = $leave->leave_type_id;
        $employee_id = $leave->employee_id;
        $balances = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
            ->select('leave_type_id', 'total', 'used', 'remain')
            ->get();
        //Leave Balance

        return view('admin.leave.leave-view', compact('active', 'leave', 'id', 'approval_id', 'approval_type', 'type', 'balances', 'leave_type'));
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

    public function adminLeaveApplicationDetails(Request $request)
    {
        $active = 'leave-details';
        $month = Carbon::now()->format('m');

        //$pendingLeaves = Leave::whereMonth('start_date', '>=', $month)->where('leave_status', LeaveStatus::PENDING)->latest()->paginate(10);
        //$approvedLeaves = Leave::whereMonth('start_date', '>=', $month)->where('leave_status', LeaveStatus::APPROVED)->latest()->paginate(10);
        //$rejectedLeaves = Leave::whereMonth('start_date', '>=', $month)->where('leave_status', LeaveStatus::REJECT)->latest()->paginate(10);
        //$cancelledLeaves = Leave::whereMonth('start_date', '>=', $month)->where('leave_status', LeaveStatus::CANCEL)->latest()->paginate(10);
        $pendingLeaves = Leave::whereHas('employee')->where('leave_status', LeaveStatus::PENDING)->latest()->paginate(10, ['*'], 'pendingPage');
        $approvedLeaves = Leave::whereHas('employee')->where('leave_status', LeaveStatus::APPROVED)->latest()->paginate(10, ['*'], 'approvedPage');
        $rejectedLeaves = Leave::whereHas('employee')->where('leave_status', LeaveStatus::REJECT)->latest()->paginate(10, ['*'], 'rejectedPage');
        $cancelledLeaves = Leave::whereHas('employee')->where('leave_status', LeaveStatus::CANCEL)->latest()->paginate(10, ['*'], 'cancelledPage');
        //  dd($approvedLeaves);
        return view(
            'admin.leave.leave-application-details',
            compact(
                'active',
                'pendingLeaves',
                'approvedLeaves',
                'rejectedLeaves',
                'cancelledLeaves'
            )
        );
    }

    public function adminLWPApplication(Request $request){
        $active = 'lwp-approvals';
        $month = Carbon::now()->format('m');
        $pendingLeaves = Leave::whereMonth('start_date', '>=', $month)->where('leave_type_id', LeaveStatus::LWP)->where('leave_status', LeaveStatus::PENDING)->latest()->paginate(10, ['*'], 'pendingPage');
        $approvedLeaves = Leave::whereMonth('start_date', '>=', $month)->where('leave_type_id', LeaveStatus::LWP)->where('leave_status', LeaveStatus::APPROVED)->latest()->paginate(10, ['*'], 'approvedPage');
        // $rejectedLeaves = Leave::whereMonth('start_date', '>=', $month)->whereMonth('end_date', '<=', $month)->where('leave_type_id', LeaveStatus::LWP)->where('leave_status', LeaveStatus::REJECT)->latest()->paginate(10);
        // $cancelledLeaves = Leave::whereMonth('start_date', '>=', $month)->whereMonth('end_date', '<=', $month)->where('leave_type_id', LeaveStatus::LWP)->where('leave_status', LeaveStatus::CANCEL)->latest()->paginate(10);
        // dd($pendingLeaves->count());
        return view(
            'admin.leave.leave-application-lwp',
            compact(
                'active',
                'pendingLeaves',
                'approvedLeaves'
            )
        );
    }

    public function adminLeaveBalanceUpdate(Request $request)
    {
        $active = 'leave-balance-update';
        $employee_id = $request->input('employee_id');
        $employee = Employee::find($employee_id);
        $leaveBalances = ($employee) ? $employee->leaveBalances()
            ->where('year', Carbon::now()->format('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', '!=', LeaveStatus::PATERNITY)
            ->where('leave_type_id', '!=', LeaveStatus::MATERNITY)
            ->get() : null;
        return view(
            'admin.leave.leave-balance-update',
            compact(
                'active',
                'employee',
                'leaveBalances'
            )
        );
    }

    public function adminLeaveBalanceUpdateSubmit(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $leaveBalances = $employee->leaveBalances()
            ->where('year', Carbon::now()->format('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', '!=', LeaveStatus::PATERNITY)
            ->where('leave_type_id', '!=', LeaveStatus::MATERNITY)
            ->get();

        foreach ($request->used as $key => $loop) {
            $leaveBalance = $leaveBalances->where('leave_type_id', $key)->first();
            if($leaveBalance){
                if ($leaveBalance->leave_type_id == LeaveStatus::LWP) {
                    $leaveBalance->total = $request->used[$key];
                    $leaveBalance->used = $request->used[$key];
                    $leaveBalance->remain = 0;
                    $leaveBalance->save();
                } else {
                    $leaveBalance->total = $request->total[$key];
                    $leaveBalance->used = $request->used[$key];
                    $leaveBalance->remain = $request->total[$key] - $request->used[$key];
                    $leaveBalance->save();
                }
            }
        }

        toastr()->success('Leave balance updated successfully.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        return redirect()->back();
    }

    public function adminCustomLeaveGenerate(Request $request)
    {
        $employeeID = $request->input('employee_id');
        $employee = Employee::find($employeeID);
        $employeeType = $employee->employeeJourney->employment_type_id;
        //if ($employeeType == EmploymentTypeStatus::PROBATION || $employeeType == EmploymentTypeStatus::PERMANENT) {}

        if (!$this->getEligibleDate($employee) && (EmploymentTypeStatus::PERMANENT == $employeeType || EmploymentTypeStatus::PROBATION == $employeeType)) {
            toastr()->Error($employee->FullName . " doesn't have permanent or probation joining date!");
            return redirect()->back();
        }
        $leaveGenerate = $this->leaveBalanceGenerate($employeeID, $employeeType, $request->all());
        if ($leaveGenerate) {
            toastr()->success('Leave balance generated for : ' . $employee->FullName);
        } else {
            toastr()->Error('Leave balance have already been generated for : ' . $employee->FullName);
        }
        return redirect()->back();
    }

    public function getEligibleDate($employee)
    {
        return (($employee->employeeJourney) && ($employee->employeeJourney->probation_start_date)) ? $employee->employeeJourney->probation_start_date : ((($employee->employeeJourney) && ($employee->employeeJourney->permanent_doj)) ? $employee->employeeJourney->permanent_doj : null);
    }

    // yearly balance generate
    public function adminLeaveBalanceGenerateYearly(){
        $active = 'leave-yearly-generate';
        $employmentTypes = EmploymentType::all();
        return view('admin.leave.leave-balance-generate-yearly', compact('active', 'employmentTypes'));
    }

    public function adminLeaveBalanceGenerateYearlySubmit(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'year' => "required",
            'employment_type_id' => "required"
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back()->withInput();
        }

        $employees = Employee::whereHas('employeeJourney', function($q) use ($request){
                $q->where('employment_type_id', $request->input('employment_type_id'));
            })
            ->with(['employeeJourney', 'leaveBalances', 'earnLeaves'])
            ->get();
        // dd($employees);

        DB::beginTransaction();

        try {
            foreach($employees as $employee) {
                $leaveBalance = $employee->leaveBalances->where('year', $request->input('year'))->where('employment_type_id', $request->input('employment_type_id'));

                if($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT){                    
                    if(!$employee->employeeJourney->permanent_doj){
                        toastr()->error('Permanent doj is missing for ID: '. $employee->employer_id . ' - ' . $employee->FullName);
                        continue;
                    } else {
                        // dd($leaveBalance->count());
                        if (!$leaveBalance->count()) {
                            (new LeaveService($employee, $request))->leaveBalanceGenerate($employee->employeeJourney->employment_type_id, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj, $alGenerate = true);
                        } else {
                            (new LeaveService($employee, $request))->leaveBalanceReGenerate($employee->employeeJourney->employment_type_id, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj, $alGenerate = true);
                            // dd($employee);
                        }
                    }
                }
                if($request->input('employment_type_id') == EmploymentTypeStatus::PROBATION){
                    if(!$employee->employeeJourney->probation_start_date){
                        toastr()->error('Probation start date is missing for ID: '. $employee->employer_id . ' - ' . $employee->FullName);
                        // continue;
                    } else {
                        if (!$leaveBalance->count()) {
                            (new LeaveService($employee, $request))->leaveBalanceGenerate($employee->employeeJourney->employment_type_id, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj, $alGenerate = true);
                        } else {
                            (new LeaveService($employee, $request))->leaveBalanceReGenerate($employee->employeeJourney->employment_type_id, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj, $alGenerate = true);
                            // dd($employee);
                        }       
                    }
                }
            }            

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Failed to generate');
            toastr()->error($e->getMessage());

        }
        return redirect()->back();

    }


    // leave balance generate
    public function leaveBalanceGenerate($employee_id, $employeeType, $request)
    {
        // dd($request);
        $employee = Employee::whereId($employee_id)->with('employeeJourney')->first();
        $leaves = LeaveBalanceSetting::where('employment_type_id', $employeeType)->get();
        $empLeaveBalance = $employee->leaveBalances()->where('year', date("Y"))->where('employment_type_id', $employee->employeeJourney->employment_type_id)->get();
        if ($empLeaveBalance->count() > 0) {
            return false;
        }
        foreach ($leaves as $key => $leave) {
            //if ($empLeaveBalance->count() > 0) {
            //    $leaveBalance = $empLeaveBalance->where('leave_type_id', $leave->leaveType->id)->first();
            //    $leaveBalance->used = (LeaveStatus::CASUAL == $leave->leaveType->id) ? $request['casual_used'] ?? 0 :
            //        ((LeaveStatus::SICK == $leave->leaveType->id) ? $request['sick_used'] ?? 0 :
            //            ((LeaveStatus::EARNED == $leave->leaveType->id) ? $request['earned_used'] ?? 0 :
            //                ((LeaveStatus::MATERNITY == $leave->leaveType->id) ? $request['maternity_used'] ?? 0 :
            //                    ((LeaveStatus::PATERNITY == $leave->leaveType->id) ? $request['paternity_used'] ?? 0 :
            //                        (LeaveStatus::LWP == $leave->leaveType->id) ? $request['lwp_used'] ?? 0 :
            //                            0
            //                    )
            //                )
            //            )
            //        );
            //    $leaveBalance->remain = (($leave->quantity - $leaveBalance->used) >= 0) ? ($leave->quantity - $leaveBalance->used) : 0;
            //} else {

            // working code
            // if (LeaveStatus::EARNED != $leave->leaveType->id) {
            //     $leaveBalance = new LeaveBalance();
            //     $leaveBalance->employee_id = $employee_id;
            //     $leaveBalance->year = date("Y");
            //     $leaveBalance->probation_start_date = $employee->employeeJourney->probation_start_date ?? null;
            //     $leaveBalance->permanent_doj = $employee->employeeJourney->probation_start_date ?? null;
            //     $leaveBalance->employment_type_id = $employeeType;
            //     $leaveBalance->leave_type_id = $leave->leaveType->id;
            //     $leaveBalance->total = $leave->quantity;
            //     $leaveBalance->used = (LeaveStatus::CASUAL == $leave->leaveType->id) ? $request['casual_used'] ?? 0 : ((LeaveStatus::SICK == $leave->leaveType->id) ? $request['sick_used'] ?? 0 : ((LeaveStatus::EARNED == $leave->leaveType->id) ? $request['earned_used'] ?? 0 : ((LeaveStatus::MATERNITY == $leave->leaveType->id) ? $request['maternity_used'] ?? 0 : ((LeaveStatus::PATERNITY == $leave->leaveType->id) ? $request['paternity_used'] ?? 0 : (LeaveStatus::LWP == $leave->leaveType->id) ? $request['lwp_used'] ?? 0 :
            //         0))));
            //     $leaveBalance->remain = (($leave->quantity - $leaveBalance->used) >= 0) ? ($leave->quantity - $leaveBalance->used) : 0;
            //     $leaveBalance->save();
            // }


            //}


        }

        // working code
        // if (EmploymentTypeStatus::PERMANENT == $employeeType || EmploymentTypeStatus::PROBATION == $employeeType) {
        //     ($request['earned_forwarded']) ? $forwarded = $request['earned_forwarded'] : $forwarded = null;

        //     foreach ($leaves as $key => $leave) {
        //         if (LeaveStatus::EARNED == $leave->leaveType->id) {
        //             if ($request['earned_used']) {
        //                 session()->put('earned_used', $request['earned_used']);
        //             }
        //             $earnLeaveService = new EarnLeaveService($employee);
        //             $earnLeaveService->generateEarnBalance($leave, $forwarded);
        //         }
        //     }
        // }

        // example code
        if ($employee->employeeJourney->employee_status_id == 1) {
            // ($request['earned_forwarded']) ? $forwarded = $request['earned_forwarded'] : $forwarded = null;
            if ($request['earned_used']) {
                session()->put('earned_used', $request['earned_used']);
            }

            $leaveBalance = $employee->leaveBalances()->where('employee_id', $employee_id)->where('year', date('Y'))->get();

            $probationLeaveBalanceExists = $leaveBalance->where('employment_type_id', EmploymentTypeStatus::PROBATION)->count();
            $permanentLeaveBalanceExists = $leaveBalance->where('employment_type_id', EmploymentTypeStatus::PERMANENT)->count();
            if (!$leaveBalance->count()) {
                //$this->leaveBalanceGenerate($employee_id, $employeeType, $request->input('probation_start_date'), $request->input('permanent_doj'));
                (new LeaveService($employee))->leaveBalanceGenerate($employeeType, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj);
            } else if (!$probationLeaveBalanceExists && !$permanentLeaveBalanceExists && $employeeType == EmploymentTypeStatus::PROBATION) {
                (new LeaveService($employee))->leaveBalanceGenerate($employeeType, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj);
            } else if (!$permanentLeaveBalanceExists && $employeeType == EmploymentTypeStatus::PERMANENT) {
                (new LeaveService($employee))->leaveBalanceGenerate($employeeType, $employee->employeeJourney->probation_start_date, $employee->employeeJourney->permanent_doj);
            }
        }

        return true;
    }

    public function adminLeaveApplyForEmployee(Request $request)
    {
        // dd($request->all());
        $today = Carbon::now();
        // $canApply = $today->subDays(15)->format('Y-m-d');

        $validator = Validator::make($request->all(), [
            // 'start_date' => "after:" . $canApply,
            'end_date' => "after_or_equal:start_date",
            'leave_reason_id' => "required",
            'file' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:5000'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        $employeeID = $request->input('employee_id');
        $employee = Employee::find($employeeID);
        $startDate = Carbon::create($request->input('start_date'));
        $endDate = Carbon::create($request->input('end_date'));
        // $quantity = ($request->input('half_day')) ? 0.5 : $startDate->diffInDays($endDate) + 1;
        $team = $employee->teamMember()->wherePivot('member_type', TeamMemberType::MEMBER)->first();
        $leaveRuleId = ($team) ? $team->leaveRule->id : null;

        $isBridge = true;
        
        $day_off_start = $employee->fixedOfficeTime->where('is_offday', 1)->where('day', Carbon::parse($startDate)->format('l'));
        //dd($day_off_start->count());
        if($day_off_start->count()){
            toastr()->error("Start date is day off!");
            return redirect()->back()->withInput();
        }

        $leaveService = new LeaveService($employee, $request);
        $leaveCheck = $leaveService->leaveCheck($startDate, $endDate, $isBridge);

        $quantity = ($request->input('half_day')) ? 0.5 : $leaveCheck['count'];

        //check if already applied for leave.
        if ($leaveService->appliedLeaveCheck($startDate, $endDate)) {
            toastr()->error('You have already applied leave for these days.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            return redirect()->back()->withInput();
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
        $leave->leave_status = LeaveStatus::APPROVED;
        $leave->leave_rule_id = $leaveRuleId;
        $leave->leave_days = json_encode($leaveCheck['days']);

        $lwp = false;
        if ($request->input('leave_type_id') == \App\Utils\LeaveStatus::LWP) {
            $leaveBalance = LeaveBalance::where('employee_id', $employeeID)
                ->where('year', date('Y'))
                ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
                ->where('leave_type_id', $request->input('leave_type_id'))
                ->first();
            $lwp = true;
        } else {
            $leaveBalance = LeaveBalance::where('employee_id', $employeeID)
                ->where('year', date('Y'))
                ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
                ->where('leave_type_id', $request->input('leave_type_id'))
                ->where('remain', '>=', $quantity)
                ->first();
        }


        if ($leaveBalance) {

            //            check attendance table and update attendance
            // $attendances = Attendance::whereEmployeeId($employeeID)->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get();
            // if ($attendances->count()) {
            //     foreach ($attendances as $attendance) {
            //         if ($attendance->status == AttendanceStatus::DAYOFF || $attendance->status == AttendanceStatus::HOLIDAY) {
            //             toastr()->error('You are applying leave on "Day Off" of "Holiday."');
            //             return redirect()->back();
            //         } elseif ($attendance->status == AttendanceStatus::PRESENT) {
            //             toastr()->error($employee->FullName . ' was present on ' . $attendance->date, 'Sorry!');
            //             return redirect()->back();
            //         }
            //     }
            //     foreach ($attendances as $attendance) {
            //         $attendance->status = $request->input('leave_type_id');
            //         $attendance->save();
            //     }
            // }

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


            $leave->supervisor_approved_by = (auth()->user()->employee_id) ? auth()->user()->employee_id : null;
            $leave->hot_approved_by = (auth()->user()->employee_id) ? auth()->user()->employee_id : null;
            // $leave->save();
            // insert leave document file name to database
            if ($request->has('file')) {
                // upload leave document
                $name = $this->documentUpload($request);
                if ($name) {
                    // save leave
                    $leave->save();
                    // save file name
                    $leave->leaveDocuments()->save(new LeaveDocument(['file_name' => $name]));

                }
            } else {
                // save leave
                $leave->save();

            }
            // deduct leave from employee leave balance
            if ($lwp) {
                $leaveBalance->increment('used', $leave->quantity);
            } else {
                $leaveBalance->decrement('remain', $leave->quantity);
                $leaveBalance->increment('used', $leave->quantity);
            }
            // send notification to the employee for approve leave
            Notification::send($employee->userDetails, new LeaveApply($leave, $employee->FullName, 'Your leave has been approved', 'leave.list'));
            toastr()->success('Leave successfully applied');
        } else {
            toastr()->error('You do not have required balance.');
            return redirect()->back();
        }
        return redirect()->back();
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



    public function adminLeaveStatus(Request $request)
    {
        $active = 'team-Leave-report';
        $userId = auth()->user()->id;

        $departments = Department::all();
        $processes = Process::all();
        $teams = Team::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            return view('admin.leave.team-leave-status', compact('active', 'departments', 'processes', 'teams'));
        }

        $nextYearTimeStamp = strtotime("1st January Next Year");


        $employee = ($request->input('employer_id')) ? Employee::where('employer_id', $request->input('employer_id'))->first() : null;
        $employeeId = (!empty($employee)) ? $employee->id : null;
        $team_id = ($request->input('team_id')) ? $request->input('team_id') : null;

        $date_from = (!empty($request->input('date_from'))) ? $request->input('date_from') : date('Y-m-d', strtotime('first day of january this year'));

        $date_to = (!empty($request->input('date_to'))) ? $request->input('date_to') : date_format(date_create(date("Y-m-d h:i:sa", $nextYearTimeStamp)), "Y-m-d");

        $department_id = ($request->input('department_id')) ? $request->input('department_id') : null;
        $process_id = ($request->input('process_id')) ? $request->input('process_id') : null;

        $queryLeave = DB::table('leaves')->leftJoin('employees', 'leaves.employee_id', 'employees.id');
        $queryLeave->select([
            'employee_id',
            'employees.employer_id',
            'employees.first_name',
            'employees.last_name',
            DB::raw("SUM(CASE WHEN leave_type_id = 1 THEN quantity ELSE 0 END) Casual"),
            DB::raw("SUM(CASE WHEN leave_type_id = 2 THEN quantity ELSE 0 END) Sick"),
            DB::raw("SUM(CASE WHEN leave_type_id = 3 THEN quantity ELSE 0 END) Earned"),
            DB::raw("SUM(CASE WHEN leave_type_id = 4 THEN quantity ELSE 0 END) Maternity"),
            DB::raw("SUM(CASE WHEN leave_type_id = 5 THEN quantity ELSE 0 END) Paternity"),
            DB::raw("SUM(CASE WHEN leave_type_id = 6 THEN quantity ELSE 0 END) LWP"),
        ]);
        $queryLeave->whereRaw("start_date >= '{$date_from}' AND end_date <= '{$date_to}'");
        $queryLeave->groupBy('employee_id');

        $query = DB::table('teams')->join('employee_team', function ($join) use ($employeeId, $department_id, $process_id, $team_id) {
            $join->on('teams.id', 'employee_team.team_id');
            $join->where("employee_team.member_type", TeamMemberType::MEMBER)
                ->when($employeeId, function ($query) use ($employeeId) {
                    $query->where('employee_team.employee_id', $employeeId);
                })
                ->when($team_id, function ($query) use ($team_id) {
                    $query->where('teams.id', $team_id);
                })
                ->when($department_id, function ($query) use ($department_id) {
                    $query->where('teams.department_id', $department_id);
                })
                ->when($process_id, function ($query) use ($process_id) {
                    $query->where('teams.process_id', $process_id);
                });
        });

        $query->join(DB::raw("(" . $queryLeave->toSql() . ") tls "), "tls.employee_id", "employee_team.employee_id");
        // dd($query->toSql());
        $teamLeaveStatus = $query->select(
            "tls.employee_id as id",
            DB::raw("(SELECT departments.name from departments where departments.id = teams.department_id) department"),
            DB::raw("(SELECT processes.name from processes where processes.id = teams.process_id) process"),
            DB::raw("(SELECT process_segments.name from process_segments where process_segments.process_id = teams.process_id) processSegment"),
            DB::raw("teams.name teamName"),
            DB::raw("CONCAT(tls.first_name, ' ', tls.last_name) emname, (tls.Casual+tls.Sick+tls.Earned+tls.Maternity+tls.Paternity+tls.LWP) as totalLeave"),
            "tls.employer_id as employer_id",
            'first_name',
            'last_name',
            "teams.name as team",
            "Casual",
            "Sick",
            "Earned",
            "Maternity",
            "Paternity",
            "LWP"
        )->paginate(10);
        // dd($teamLeaveStatus);
        $leave_types = LeaveType::get();
        // dd($leave_types);
        return view('admin.leave.team-leave-status', compact('active', 'departments', 'processes', 'teams', 'teamLeaveStatus', 'leave_types'));
    }


    public function leaveDetails($id = null)
    {
        $active = 'Leave-report';
        $employee_id = ($id == null) ? auth()->user()->employee_id : $id;
        $employee = Employee::whereId($employee_id)->with(['employeeJourney'])->first();
        $leaveBalance = LeaveBalance::where('employee_id', $employee_id)->where('year', date('Y'))
            ->select('leave_type_id', 'total', 'used', 'remain')
            ->get();
        $leaves = Leave::where('employee_id', $employee_id)->get();
        // dd($leaves);
        return view('admin.leave.leave-detail', compact('active', 'leaves', 'leaveBalance', 'id', 'employee'));
    }

    public function deleteLeave($id)
    {
        Leave::find($id)->delete();
        return redirect()->route('admin.leave.application.details');
    }
}
