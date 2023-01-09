<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;
use App\Attendance;
use App\AttendanceChangeRequest;
use App\Center;
use App\Charts\AdminChart;
use Carbon\Carbon;
use App\Employee;
use App\Department;
use App\Division;
use App\EmployeeFixedOfficeTime;
use App\Leave;
use App\LeaveReason;
use App\Process;
use App\Roster;
use App\Utils\AttendanceChangeStatus;
use App\Utils\AttendanceStatus;
use App\Utils\LeaveStatus;
use Illuminate\Support\Facades\DB;

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
    }

    // ajax request for attendance details
    public function attendanceDetails(Request $request)
    {
        $attendance = Attendance::find($request->input('attendance_id'));
        //return $attendance;
        $overTime = 'No overtime.';
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


        return view('admin.attendence.attendance-modal-details', compact('attendance', 'workHours', 'overTime'));
    }



    // employee attendance from admin
    public function employeeAttendance(Request $request)
    {
        $active = 'employee-attendance';
        $df = $request->has('month') ? $request->input('month') : Carbon::now()->format('Y-m-d');
        $dt = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y-m-d');
        $requestTest = $request->all();
        if (!$requestTest) {
            return view('admin.attendence.employee-attendance', compact('active', 'df', 'dt'));
        }
        // $df = $request->input('datefrom');
        $df = date_format(date_create($request->input('datefrom')), "Y-m-d");
        // $dt = $request->input('dateto');
        $dt = date_format(date_create($request->input('dateto')), "Y-m-d");
        $departmentRequest = $request->input('department_id');
        $processRequest = $request->input('process_id');
        $divisionRequest = $request->input('division');
        $centerRequest = $request->input('center');
        $shift = $request->input('shift');
        $employee_id = $request->input('employee_id');
        $division_id = Division::where('name', session()->get('division'))->first()->id;
        $center_id = Center::where('center', session()->get('center'))->first()->id;
        // dd($shift);
        $employees = Employee::select('id', 'first_name', 'last_name', 'employer_id')
            ->whereHas('attendances', function ($query) use ($df, $dt) {
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
            ->with(['attendances' => function ($query) use ($df, $dt, $shift) {
                $query->whereBetween('date', array($df, $dt))
                    ->when($shift, function ($query) use ($shift) {
                        return $query->whereTime('roster_start', $shift);
                    });
            }, 'departmentProcess'])
            ->orderBy('first_name', 'asc')
            ->paginate(50);
        // return ($employees);
        $tableDate = [];
        foreach ($employees as $items) {
            foreach ($items->attendances as $item) {
                $tableDate[$item->date] = $item->date;
            }
        }

        $tableDate = ($tableDate) ? array_keys($tableDate) : null;
        return view('admin.attendence.employee-attendance', compact(
            'active',
            'employees',
            'df',
            'dt',
            'tableDate',
            'departmentRequest',
            'processRequest',
            'tableDate',
            'employee_id',
            'shift'
        ));
    }
    
    public function employeeDepartmentAttendance(Request $request)
    {
        $active = 'employee-dept-attendance';
        $df = $request->has('month') ? $request->input('month') : Carbon::now()->format('Y-m-d');
        $dt = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y-m-d');
        $divisions = Division::all();
        $requestTest = $request->all();
        if (!$requestTest) {
            return view('admin.attendence.employee-dept-attendance', compact('active', 'df', 'dt', 'divisions'));
        }
        // $df = $request->input('datefrom');
        $df = date_format(date_create($request->input('datefrom')), "Y-m-d");
        // $dt = $request->input('dateto');
        $dt = date_format(date_create($request->input('dateto')), "Y-m-d");
        $departmentRequest = $request->input('department');
        $processRequest = $request->input('process');
        $centerRequest = $request->input('center');
        $divisionRequest = $request->input('division');
        $shift = $request->input('shift');
        $employee_id = $request->input('employee_id');
        // dd($shift);
        $employees = Employee::select('id', 'first_name', 'last_name', 'employer_id')
            ->whereHas('attendances', function ($query) use ($df, $dt) {
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
            ->orderBy('first_name', 'asc')
            ->get();
        // return ($employees);
        $tableDate = [];
        foreach ($employees as $items) {
            foreach ($items->attendances as $item) {
                $tableDate[$item->date] = $item->date;
            }
        }

        $tableDate = ($tableDate) ? array_keys($tableDate) : null;
        return view('admin.attendence.employee-dept-attendance', compact(
            'active',
            'employees',
            'df',
            'dt',
            'tableDate',
            'departmentRequest',
            'processRequest',
            'tableDate',
            'employee_id',
            'shift',
            'divisions'
        ));
    }

    // TODO Attendanc Dashboard
    public function attendanceDashboard(Request $request)
    {


        $active = 'attendance-dashboard';
        $divisions = Division::all();
        $centers = Center::all();
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');


        $attendanceTotal = Attendance::select(['id', 'date', 'status'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            // ->whereIn('status', [AttendanceStatus::PRESENT, AttendanceStatus::LATE, AttendanceStatus::WITHOUT_ROSTER, AttendanceStatus::EARLY_LEAVE, AttendanceStatus::ABSENT])
            ->whereIn('status', [AttendanceStatus::PRESENT, AttendanceStatus::LATE, AttendanceStatus::ABSENT])
            ->get();
        $attendanceTotalCount = $attendanceTotal->count();

        $presentPercent = ($attendanceTotalCount) ? number_format((($attendanceTotal->where('status', AttendanceStatus::PRESENT)->count() + $attendanceTotal->where('status', AttendanceStatus::LATE)->count()) / $attendanceTotal->count()) * 100, 2) : 0;
        $absentPercent = ($attendanceTotalCount) ? number_format(($attendanceTotal->where('status', AttendanceStatus::ABSENT)->count() / $attendanceTotal->count()) * 100, 2) : 0;
        $ontimePercent = ($attendanceTotalCount) ? number_format(($attendanceTotal->where('status', AttendanceStatus::PRESENT)->count() / $attendanceTotal->count()) * 100, 2) : 0;
        $latePercent = ($attendanceTotalCount) ? number_format(($attendanceTotal->where('status', AttendanceStatus::LATE)->count() / $attendanceTotal->count()) * 100, 2) : 0;


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


        // male vs female absent ration
        $maleAbsent = Attendance::select(['id', 'employee_id', 'date', 'status'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereHas('employee', function ($q) {
                return $q->male();
            })
            ->where('status', AttendanceStatus::ABSENT)
            ->count();

        $femaleAbsent = Attendance::select(['id', 'employee_id', 'date', 'status'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereHas('employee', function ($q) {
                return $q->female();
            })
            ->where('status', AttendanceStatus::ABSENT)
            ->count();

        $totalAbsent = $maleAbsent + $femaleAbsent;

        $genderRatio = new AdminChart();
        $genderRatio->options([
            'showAllTooltips' => true
        ]);
        $genderRatio->labels(['Male', 'Female']);
        $genderRatio->dataset('Gender', 'pie', ($totalAbsent) ? [number_format(($maleAbsent / ($totalAbsent)) * 100, 2), number_format(($femaleAbsent / ($totalAbsent)) * 100, 2)] : [0, 0])->color($borderColors)->backgroundcolor($fillColors);



        // Dhaka vs CTG absent ratio
        $dhakaAbsent = Attendance::select(['id', 'employee_id', 'date', 'status'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereHas('employee', function ($q) {
                return $q->dhakaCenter();
            })
            ->where('status', AttendanceStatus::ABSENT)
            ->count();

        $ctgAbsent = Attendance::select(['id', 'employee_id', 'date', 'status'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereHas('employee', function ($q) {
                return $q->ctgCenter();
            })
            ->where('status', AttendanceStatus::ABSENT)
            ->count();

        $totalDhkVSCtgAbsent = $dhakaAbsent + $ctgAbsent;

        $dhkVsCtg = new AdminChart();
        $dhkVsCtg->options([
            'showAllTooltips' => true
        ]);
        $dhkVsCtg->labels(['DHK', 'CTG']);
        $dhkVsCtg->dataset('Center', 'pie', ($totalDhkVSCtgAbsent) ? [number_format(($dhakaAbsent / ($totalDhkVSCtgAbsent)) * 100, 2), number_format(($ctgAbsent / ($totalDhkVSCtgAbsent)) * 100, 2)] : [0, 0])->color($borderColors)->backgroundcolor($fillColors);


        // department wise attendance report
        $departments = Department::all();
        foreach ($departments as $dept) {
            $employees = Employee::select('id')->whereHas('departmentProcess', function ($q) use ($dept) {
                $q->where('department_id', $dept->id);
            })->get();
            $employeeIds = ($employees->count()) ? $employees->reduce(function ($ids, $employee) {
                $ids[] = $employee->id;
                return $ids;
            }) : null;
            ($employeeIds && count($employeeIds)) ? $attendance = Attendance::whereIn('employee_id', $employeeIds)->whereMonth('date', $month)->whereYear('date', $year)->get() : $attendance = null;

            $departmentWistAtt[] = [
                'name' => $dept->name,
                'present' => ($attendance) ? $attendance->where('status', AttendanceStatus::PRESENT)->count() + $attendance->where('status', AttendanceStatus::LATE)->count() : 0,
                'absent' => ($attendance) ? $attendance->where('status', AttendanceStatus::ABSENT)->count() : 0,
                'late' => ($attendance) ? $attendance->where('status', AttendanceStatus::LATE)->count() : 0
            ];
        }
        $departmentHeadCount = new AdminChart();
        $departmentHeadCount->labels(array_column($departmentWistAtt, 'name'));
        $departmentHeadCount->dataset('Present', 'bar', array_column($departmentWistAtt, 'present'))->color('rgba(46,125,50, 0.7)')->backgroundcolor('rgba(46,125,50, 0.7)');
        $departmentHeadCount->dataset('Late', 'bar', array_column($departmentWistAtt, 'late'))->color("rgba(255, 205, 86, 0.7)")->backgroundcolor("rgba(255, 205, 86, 0.7)");
        $departmentHeadCount->dataset('Absent', 'bar', array_column($departmentWistAtt, 'absent'))->color("rgba(244,67,54, 0.7)")->backgroundcolor("rgba(244,67,54, 0.7)");



        return view(
            'admin.attendence.dashboard-attendance',
            compact(
                'active',
                'month',
                'year',
                'divisions',
                'centers',
                'presentPercent',
                'absentPercent',
                'ontimePercent',
                'latePercent',
                'genderRatio',
                'dhkVsCtg',
                'departmentHeadCount'
            )
        );

        // if (!$request->has('division')) {
        //     $teamDetailsTable  = null;
        //     $processWiseHeadCount  = null;
        //     $processWiseOntimeLate  = null;
        //     return view(
        //         'admin.attendence.dashboard-attendance',
        //         compact(
        //             'active',
        //             'month',
        //             'year',
        //             'divisions',
        //             'centers',
        //             'presentPercent',
        //             'absentPercent',
        //             'ontimePercent',
        //             'latePercent',
        //             'genderRatio',
        //             'dhkVsCtg',
        //             'departmentHeadCount',
        //             'teamDetailsTable',
        //             'processWiseHeadCount',
        //             'processWiseOntimeLate'
        //         )
        //     );
        // }
        // ================= process wise Report =========================== //
        // dd($request->all());

        // $teams = Team::when($request->input('division'), function ($q) use ($request) {
        //     $q->where('division_id', $request->input('division'));
        // })
        //     ->when($request->input('center'), function ($q) use ($request) {
        //         $q->where('center_id', $request->input('center'));
        //     })
        //     ->when($request->input('department'), function ($q) use ($request) {
        //         $q->where('department_id', $request->input('department'));
        //     })
        //     ->when($request->input('process'), function ($q) use ($request) {
        //         $q->where('process_id', $request->input('process'));
        //     })
        //     ->when($request->input('process_segment'), function ($q) use ($request) {
        //         $q->where('process_segment_id', $request->input('process_segment'));
        //     })
        //     ->with(['teamLead', 'employees'])
        //     ->get();

        // // teamlead table dataset
        // foreach ($teams as $team) {
        //     $empIds = $team->employees->reduce(function ($ids, $employee) {
        //         $ids[] = $employee->id;
        //         return $ids;
        //     });

        //     ($empIds && count($empIds)) ? $attendance = Attendance::whereIn('employee_id', $empIds)->whereMonth('date', $month)->whereYear('date', $year)->where('status', AttendanceStatus::ABSENT)->count() : $attendance = 0;
        //     $teamDetailsTable[] = [
        //         'teamLeadName' => $team->teamLead->FullName,
        //         'member' => $team->employees->count(),
        //         'Absent' => $attendance,
        //     ];
        // }


        // if ($empIds && count($empIds)) {
        //     $attendanceForLineChart = $attendanceForBarChart = Attendance::whereIn('employee_id', $empIds)->whereMonth('date', $month)->whereYear('date', $year)->get();
        // }
        // $processWiseHeadCountData = [];
        // foreach ($attendanceForLineChart->groupBy('date') as $date => $attendance) {
        //     $processWiseHeadCountData[] = [
        //         'date' => $date,
        //         'present' => $attendance->where('date', $date)->where('status', AttendanceStatus::PRESENT)->count() + $attendance->where('date', $date)->where('status', AttendanceStatus::LATE)->count(),
        //     ];
        // }
        // $processWiseHeadCount = new AdminChart();
        // $processWiseHeadCount->labels(array_column($processWiseHeadCountData, 'date'));
        // $processWiseHeadCount->dataset('Present', 'line', array_column($processWiseHeadCountData, 'present'))->color($borderColors)->backgroundcolor($fillColors);

        // $processWiseOnTimeCountData = [];
        // foreach ($attendanceForBarChart->groupBy('date') as $date => $attendance) {
        //     $processWiseOnTimeCountData[] = [
        //         'date' => $date,
        //         'onTime' => $attendance->where('date', $date)->where('status', AttendanceStatus::PRESENT)->count(),
        //         'late' => $attendance->where('date', $date)->where('status', AttendanceStatus::LATE)->count(),
        //     ];
        // }
        // // dd($processWiseOnTimeCountData);
        // $processWiseOntimeLate = new AdminChart();
        // $processWiseOntimeLate->labels(array_column($processWiseOnTimeCountData, 'date'));
        // $processWiseOntimeLate->dataset('Ontime', 'bar', array_column($processWiseOnTimeCountData, 'present'))->color($borderColors)->backgroundcolor($fillColors);
        // $processWiseOntimeLate->dataset('Late', 'bar', array_column($processWiseOnTimeCountData, 'late'))->color($borderColors)->backgroundcolor($fillColors);


        // return view(
        //     'admin.attendence.dashboard-attendance',
        //     compact(
        //         'active',
        //         'month',
        //         'year',
        //         'divisions',
        //         'centers',
        //         'presentPercent',
        //         'absentPercent',
        //         'ontimePercent',
        //         'latePercent',
        //         'genderRatio',
        //         'dhkVsCtg',
        //         'departmentHeadCount',
        //         // 'processWiseHeadCount',
        //         // 'processWiseOntimeLate',
        //         // 'teamDetailsTable'
        //     )
        // );
    }


    public function attendanceLeaveDashboardProcessWise(Request $request)
    {

        $active = 'attendance-dashboard';
        $divisions = Division::all();
        $centers = Center::all();
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');


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


        // // male vs female absent ration
        // $maleAbsent = Attendance::select(['id','employee_id','date','status'])
        //                         ->whereMonth('date', $month)
        //                         ->whereYear('date', $year)
        //                         ->whereHas('employee', function($q){
        //                             return $q->male();
        //                         })
        //                         ->where('status', AttendanceStatus::ABSENT)
        //                         ->count();

        // $femaleAbsent = Attendance::select(['id','employee_id','date','status'])
        //                         ->whereMonth('date', $month)
        //                         ->whereYear('date', $year)
        //                         ->whereHas('employee', function($q){
        //                             return $q->female();
        //                         })
        //                         ->where('status', AttendanceStatus::ABSENT)
        //                         ->count();

        // $totalAbsent = $maleAbsent + $femaleAbsent;

        // $genderRatio = new AdminChart();
        // $genderRatio->options([
        //     'showAllTooltips' => true
        // ]);
        // $genderRatio->labels(['Male', 'Female']);
        // $genderRatio->dataset('Gender', 'pie', ($totalAbsent) ? [number_format(($maleAbsent/($totalAbsent))*100, 2), number_format(($femaleAbsent/($totalAbsent))*100, 2)] : [0,0])->color($borderColors)->backgroundcolor($fillColors);



        // // Dhaka vs CTG absent ratio
        // $dhakaAbsent = Attendance::select(['id','employee_id','date','status'])
        //                         ->whereMonth('date', $month)
        //                         ->whereYear('date', $year)
        //                         ->whereHas('employee', function($q){
        //                             return $q->dhakaCenter();
        //                         })
        //                         ->where('status', AttendanceStatus::ABSENT)
        //                         ->count();

        // $ctgAbsent = Attendance::select(['id','employee_id','date','status'])
        //                         ->whereMonth('date', $month)
        //                         ->whereYear('date', $year)
        //                         ->whereHas('employee', function($q){
        //                             return $q->ctgCenter();
        //                         })
        //                         ->where('status', AttendanceStatus::ABSENT)
        //                         ->count();

        // $totalDhkVSCtgAbsent = $dhakaAbsent + $ctgAbsent;

        // $dhkVsCtg = new AdminChart();
        // $dhkVsCtg->options([
        //     'showAllTooltips' => true
        // ]);
        // $dhkVsCtg->labels(['DHK', 'CTG']);
        // $dhkVsCtg->dataset('Center', 'pie', ($totalDhkVSCtgAbsent) ? [number_format(($dhakaAbsent/($totalDhkVSCtgAbsent))*100, 2), number_format(($ctgAbsent/($totalDhkVSCtgAbsent))*100, 2)] : [0,0])->color($borderColors)->backgroundcolor($fillColors);


        // // department wise attendance report
        // $departments = Department::all();
        // foreach($departments as $dept){
        //     $employees = Employee::select('id')->whereHas('departmentProcess', function($q) use ($dept){
        //         $q->where('department_id', $dept->id);
        //     })->get();
        //     $employeeIds = ($employees->count()) ? $employees->reduce(function($ids, $employee){
        //                         $ids[] = $employee->id;
        //                         return $ids;
        //                     }) : null;
        //     ($employeeIds && count($employeeIds)) ? $attendance = Attendance::whereIn('employee_id', $employeeIds)->whereMonth('date', $month)->whereYear('date', $year)->get() : $attendance = null;

        //     $departmentWistAtt[] = [
        //         'name' => $dept->name,
        //         'present' => ($attendance) ? $attendance->where('status', AttendanceStatus::PRESENT)->count() : 0,
        //         'absent' => ($attendance) ? $attendance->where('status', AttendanceStatus::ABSENT)->count() : 0,
        //         'late' => ($attendance) ? $attendance->where('status', AttendanceStatus::LATE)->count() : 0
        //     ];
        // }
        // $departmentHeadCount = new AdminChart();
        // $departmentHeadCount->labels(array_column($departmentWistAtt, 'name'));
        // $departmentHeadCount->dataset('Present', 'bar', array_column($departmentWistAtt, 'present'))->color($borderColors)->backgroundcolor($fillColors);
        // $departmentHeadCount->dataset('Absent', 'bar', array_column($departmentWistAtt, 'absent'))->color($borderColors)->backgroundcolor($fillColors);
        // $departmentHeadCount->dataset('Late', 'bar', array_column($departmentWistAtt, 'late'))->color($borderColors)->backgroundcolor($fillColors);


        if (!$request->has('division')) {
            $teamDetailsTable  = null;
            $teamLeaveDetailsTable  = null;
            $processWiseHeadCount  = null;
            $processWiseOntimeLate  = null;
            $presentPercent  = 0;
            $absentPercent  = 0;
            $ontimePercent  = 0;
            $latePercent  = 0;
            $totalSl  = 0;
            $totalCl  = 0;
            $totalEl  = 0;
            $totalOther  = 0;
            $processWiseLeaveCount = null;
            $leaveReason = null;
            return view(
                'admin.attendence.dashboard-attendance-leave-process-wise',
                compact(
                    'active',
                    'month',
                    'year',
                    'divisions',
                    'centers',
                    'presentPercent',
                    'absentPercent',
                    'ontimePercent',
                    'latePercent',
                    // 'genderRatio',
                    // 'dhkVsCtg',
                    // 'departmentHeadCount',
                    'teamDetailsTable',
                    'teamLeaveDetailsTable',
                    'processWiseHeadCount',
                    'processWiseOntimeLate',
                    'totalSl',
                    'totalCl',
                    'totalEl',
                    'totalOther',
                    'processWiseLeaveCount',
                    'leaveReason'
                )
            );
        }
        // ================= process wise Report =========================== //
        // dd($request->all());

        $teams = Team::when($request->input('division'), function ($q) use ($request) {
            $q->where('division_id', $request->input('division'));
        })
            ->when($request->input('center'), function ($q) use ($request) {
                $q->where('center_id', $request->input('center'));
            })
            ->when($request->input('department'), function ($q) use ($request) {
                $q->where('department_id', $request->input('department'));
            })
            ->when($request->input('process'), function ($q) use ($request) {
                $q->where('process_id', $request->input('process'));
            })
            ->when($request->input('process_segment'), function ($q) use ($request) {
                $q->where('process_segment_id', $request->input('process_segment'));
            })
            ->with(['teamLead', 'employees'])
            ->get();

        // teamlead table dataset
        $empIds = [];
        $teamDetailsTable = [];
        $attendance = 0;
        foreach ($teams as $team) {
            $empIds[] = $ids =  $team->employees->reduce(function ($ids, $employee) {
                $ids[] = $employee->id;
                return $ids;
            });

            ($empIds && count($empIds)) ? $attendance = Attendance::whereIn('employee_id', $ids)->whereMonth('date', $month)->whereYear('date', $year)->where('status', AttendanceStatus::ABSENT)->count() : $attendance = 0;
            $teamDetailsTable[] = [
                'teamLeadName' => $team->teamLead->FullName,
                'member' => $team->employees->count(),
                'Absent' => $attendance,
            ];
        }
        $empIds = $this->array_2d_to_1d($empIds);


        $attendanceTotal = Attendance::select(['id', 'date', 'status'])
            ->whereIn('employee_id', $empIds)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereIn('status', [AttendanceStatus::PRESENT, AttendanceStatus::LATE, AttendanceStatus::ABSENT])
            ->get();
        $attendanceTotalCount = $attendanceTotal->count();


        $presentPercent = ($attendanceTotalCount) ? number_format((($attendanceTotal->where('status', AttendanceStatus::PRESENT)->count() + $attendanceTotal->where('status', AttendanceStatus::LATE)->count()) / $attendanceTotal->count()) * 100, 2) : 0;
        $absentPercent = ($attendanceTotalCount) ? number_format(($attendanceTotal->where('status', AttendanceStatus::ABSENT)->count() / $attendanceTotal->count()) * 100, 2) : 0;
        $ontimePercent = ($attendanceTotalCount) ? number_format(($attendanceTotal->where('status', AttendanceStatus::PRESENT)->count() / $attendanceTotal->count()) * 100, 2) : 0;
        $latePercent = ($attendanceTotalCount) ? number_format(($attendanceTotal->where('status', AttendanceStatus::LATE)->count() / $attendanceTotal->count()) * 100, 2) : 0;



        $attendanceForLineChart = $attendanceForBarChart = Attendance::whereIn('employee_id', $empIds)->whereMonth('date', $month)->whereYear('date', $year)->get();
        // if ($empIds && count($empIds)) {
        //     $attendanceForLineChart = $attendanceForBarChart = Attendance::whereIn('employee_id', $empIds)->whereMonth('date', $month)->whereYear('date', $year)->get();
        // }
        $processWiseHeadCountData = [];
        foreach ($attendanceForLineChart->groupBy('date') as $date => $attendance) {
            $processWiseHeadCountData[] = [
                'date' => $date,
                'present' => $attendance->where('date', $date)->where('status', AttendanceStatus::PRESENT)->count() + $attendance->where('date', $date)->where('status', AttendanceStatus::LATE)->count(),
            ];
        }
        $processWiseHeadCount = new AdminChart();
        $processWiseHeadCount->labels(array_column($processWiseHeadCountData, 'date'));
        $processWiseHeadCount->dataset('Present', 'line', array_column($processWiseHeadCountData, 'present'))->color($borderColors)->backgroundcolor($fillColors);

        $processWiseOnTimeCountData = [];
        foreach ($attendanceForBarChart->groupBy('date') as $date => $attendance) {
            $processWiseOnTimeCountData[] = [
                'date' => $date,
                'present' => $attendance->where('date', $date)->where('status', AttendanceStatus::PRESENT)->count() + $attendance->where('date', $date)->where('status', AttendanceStatus::LATE)->count(),
                'onTime' => $attendance->where('date', $date)->where('status', AttendanceStatus::PRESENT)->count(),
                'late' => $attendance->where('date', $date)->where('status', AttendanceStatus::LATE)->count(),
            ];
        }
        // dd($processWiseOnTimeCountData);
        $processWiseOntimeLate = new AdminChart();
        $processWiseOntimeLate->labels(array_column($processWiseOnTimeCountData, 'date'));
        $processWiseOntimeLate->dataset('Present', 'bar', array_column($processWiseOnTimeCountData, 'present'))->color("rgba(120, 43, 144, 0.7)")->backgroundcolor("rgba(120, 43, 144, 0.7)");
        $processWiseOntimeLate->dataset('Ontime', 'bar', array_column($processWiseOnTimeCountData, 'onTime'))->color('rgba(46,125,50, 0.7)')->backgroundcolor('rgba(46,125,50, 0.7)');
        $processWiseOntimeLate->dataset('Late', 'bar', array_column($processWiseOnTimeCountData, 'late'))->color("rgba(244,67,54, 0.7)")->backgroundcolor("rgba(244,67,54, 0.7)");


        // ================= leave report ================
        $leaveAll = Leave::select(['id', 'employee_id', 'start_date', 'end_date', 'leave_reason_id', 'leave_type_id', 'leave_status', 'quantity'])
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->whereIn('employee_id', $empIds)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->with(['employee' => function ($q) {
                $q->withoutGlobalScopes();
            }], 'leaveReason')
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


        $teamLeaveDetailsTable = [];
        $leave = 0;
        foreach ($teams as $team) {
            $leave = 0;
            $leaveCount = 0;
            $ids =  $team->employees->reduce(function ($ids, $employee) {
                $ids[] = $employee->id;
                return $ids;
            });

            ($ids && count($ids)) ? $leave = Leave::whereIn('employee_id', $ids)->whereMonth('start_date', $month)->whereYear('start_date', $year)->where('leave_status', LeaveStatus::APPROVED)->get() : $leave = 0;
            if ($leave) {
                foreach ($leave as $item) {
                    $leaveCount += $item->quantity;
                }
            }
            $teamLeaveDetailsTable[] = [
                'teamLeadName' => $team->teamLead->FullName,
                'member' => $team->employees->count(),
                'leave' => $leaveCount,
            ];
        }

        $processWiseLeaveCountData = $leaveAll->groupBy('start_date')
            ->map(function ($item, $key) {
                return (int) $item->sum('quantity');
            });

        $processWiseLeaveCount = new AdminChart();
        $processWiseLeaveCount->labels($processWiseLeaveCountData->keys());
        $processWiseLeaveCount->dataset('Leaves', 'line', $processWiseLeaveCountData->values())->color($borderColors)->backgroundcolor($fillColors);

        // Leave reason wise report

        $leaveReasonData = $leaveAll->groupBy(function ($item, $key) {
            return $item->leaveReason->leave_reason;
        })->map(function ($item, $key) {
            return (int) $item->sum('quantity');
        });
        $leaveReason = new AdminChart();
        $leaveReason->displayAxes(true);
        $leaveReason->labels($leaveReasonData->keys());
        $leaveReason->dataset('Leave Reason', 'bar', $leaveReasonData->values())->color($borderColors)->backgroundcolor($fillColors);

        return view(
            'admin.attendence.dashboard-attendance-leave-process-wise',
            compact(
                'active',
                'month',
                'year',
                'divisions',
                'centers',
                'presentPercent',
                'absentPercent',
                'ontimePercent',
                'latePercent',
                // 'genderRatio',
                // 'dhkVsCtg',
                // 'departmentHeadCount',
                'processWiseHeadCount',
                'processWiseOntimeLate',
                'teamDetailsTable',
                'totalSl',
                'totalCl',
                'totalEl',
                'totalOther',
                'processWiseLeaveCount',
                'leaveReason',
                'teamLeaveDetailsTable'
            )
        );
    }

    function array_2d_to_1d($input_array)
    {
        $output_array = array();

        for ($i = 0; $i < count($input_array); $i++) {
            for ($j = 0; $j < count($input_array[$i]); $j++) {
                $output_array[] = $input_array[$i][$j];
            }
        }

        return array_unique($output_array);
    }


    public function attendanceChangeApproval(Request $request)
    {
        $active = 'attendance-change-request';

        // dd($request->all());

        if ($request->has('employee_id')) {
            $changeRequests = AttendanceChangeRequest::where('employee_id', $request->get('employee_id'))->where('first_approve_status', AttendanceChangeStatus::APPROVED)->orderBy('final_approve_status', 'asc')->paginate(10);
        } else {
            $changeRequests = AttendanceChangeRequest::where('first_approve_status', AttendanceChangeStatus::APPROVED)->orderBy('final_approve_status', 'asc')->paginate(10);
        }

        return view(
            'admin.attendence.change-request',
            compact(
                'active',
                'changeRequests'
            )
        );
    }

    public function attendanceChangeApprovalSubmit(Request $request)
    {
        $change_request = AttendanceChangeRequest::find($request->get('change_id'));
        if ($request->get('submit') == 'approve') {
            $attendance = Attendance::where('employee_id', $change_request->employee_id)->where('date', $change_request->date)->first();
            if ($change_request->roster_start) {
                $attendance->roster_start = $change_request->roster_start;
            }
            // elseif ($change_request->is_adjusted_day_off) {
            //     $attendance->roster_start = null;
            // }

            if ($change_request->roster_end) {
                $attendance->roster_end = $change_request->roster_end;
            }
            // elseif ($change_request->is_adjusted_day_off) {
            //     $attendance->roster_end = null;
            // }

            if ($change_request->punch_in) {
                $attendance->punch_in = $change_request->punch_in;
            }
            // elseif ($change_request->is_adjusted_day_off) {
            //     $attendance->punch_in = null;
            // }

            if ($change_request->punch_out) {
                $attendance->punch_out = $change_request->punch_out;
            }
            // elseif ($change_request->is_adjusted_day_off) {
            //     $attendance->punch_out = null;
            // }

            $workMinutes = Carbon::create($change_request->punch_in)->diffInMinutes(Carbon::create($change_request->punch_out));
            $workHours = intdiv($workMinutes, 60) . ':' . ($workMinutes % 60);
            $late = round((strtotime($change_request->punch_in) - strtotime($attendance->roster_start)) / 60, 2);

            $attendance->work_hours = $workHours;
            $attendance->remarks = $change_request->remarks;
            // $attendance->status = ($change_request->out_of_office) ? AttendanceStatus::PRESENT : (($late > 30) ? AttendanceStatus::LATE : AttendanceStatus::PRESENT);
            if ($change_request->is_adjusted_day_off) {
                $attendance->status = AttendanceStatus::ADJUSTED_DAY_OFF;
            } elseif ($change_request->out_of_office) {
                $attendance->status = AttendanceStatus::PRESENT;
            } elseif ($late > 30) {
                $attendance->status = AttendanceStatus::LATE;
            } else {
                $attendance->status = AttendanceStatus::PRESENT;
            }

            if ($attendance->save()) {
                $change_request->final_approve_status = AttendanceChangeStatus::APPROVED;
                $change_request->save();
            }
            toastr()->success("You approved the request.", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        } elseif ($request->get('submit') == 'reject') {
            $change_request->final_approve_status = AttendanceChangeStatus::REJECTED;
            $change_request->save();
            toastr()->error("You rejected the request.", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        }
        return redirect()->back();
    }
    
    public function updateAttendanceStatusView(Request $request){
        $active = 'exec-attendance-upload';
        return view('admin.attendence.attendanceStatusUpdate', compact('active'));
    }
    public function updateAttendanceStatus(Request $request){

        $date = date('Y-m-d', strtotime($request->input('date')));
        $day = date('l', strtotime($request->input('date')));
        $remarks = '';
        $employees = EmployeeFixedOfficeTime::distinct()->pluck('employee_id');

        foreach($employees as $employee_id){
            $remarks = '';
            $employee = Employee::withoutGlobalScopes()->where('id', $employee_id)->first();
            if($employee->employeeJourney->employee_status_id == 1){                            
                
                $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();                
                $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee->id)->first(); 
                $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();
                
                if($fixedRoster) {                    
                    
                    $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                    $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));

                    if (!empty($existAttendance)) {
                        if ($existAttendance->punch_in) {
                            if ($fixedRoster->is_offday == 1) {
                                $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                            } else {
                                $roster_entry_time = strtotime($startTime);
                                $punch_in_time = strtotime($existAttendance->punch_in);
                                $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                                
                                $status = AttendanceStatus::PRESENT;
                                if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                    $status = $leaveCheck->leave_type_id;
                                } else if(Carbon::parse($startTime)->format('H:i:s') && $late > 15){
                                    $status = AttendanceStatus::LATE;
                                    $remarks = $existAttendance->remarks;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 4.5){
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 7.5){
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') > 7.5){
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                } else {
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                }
                            }
                        } else {                            
                            if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                $status = $leaveCheck->leave_type_id;
                            } else if ($fixedRoster->is_offday == 1){
                                $status = AttendanceStatus::DAYOFF;
                                $remarks = '';
                            } else {
                                $status = AttendanceStatus::ABSENT;
                                $remarks = '';
                            }
                        }
                        DB::table('attendances')->where('date', $date)->where('employee_id', $employee->id)->update([
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'status' => $status,
                            'remarks' => $remarks
                        ]);
                    } else {

                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else if ($fixedRoster->is_offday == 1){
                            $status = AttendanceStatus::DAYOFF;
                        } else {
                            $status = AttendanceStatus::ABSENT;
                        }

                        $dataArray = array(
                            'employee_id' =>  $employee->id,
                            'date' => $date,
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'status' => $status,
                            'remarks' => $remarks
                        );
                        DB::table('attendances')->insert($dataArray);                    
                    }
                }
            }             
        } 
        toastr()->success("Attendance status update", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        return redirect()->back();
    }
}
