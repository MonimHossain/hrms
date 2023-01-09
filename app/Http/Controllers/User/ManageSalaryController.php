<?php

namespace App\Http\Controllers\User;

use App\Adjustment;
use App\AdjustmentType;
use App\BankBranch;
use App\BankInfo;
use App\Center;
use App\EmployeeStatus;
use App\Imports\EmployeeHourImport;
use App\IndividualOtherAllowance;
use App\IndividualSalary;
use App\IndividualSalaryBreakdown;
use App\IndividualSalaryIncrement;
use App\Jobs\NotifyUserOfCompletedEmployeeHourImport;
use App\Jobs\NotifyUserOfCompletedEmployeeAttendanceImport;
use App\PayCycle;
use App\PaymentType;
use App\ProvidentFundSetting;
use App\SalaryBreakdownSetting;
use App\Scopes\DivisionCenterScope;
use App\TaxSetting;
use App\Utils\Permissions;
use Illuminate\Http\Request;
use App\Employee;
use App\EmploymentType;
use App\EmployeeJourney;
use App\Clearance;
use App\SalaryHoldList;
use App\salaryHistory;
use App\SalarySummaryHistory;
use App\Attendance;
use App\Division;
use App\EmployeeHours;
use App\Kpi;
use App\Http\Controllers\Controller;
use App\Leave;
use App\Services\GenerateSalaryService;
use App\Services\PayrollService;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\Payroll;
use DB;
use Auth;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use Validator;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use App\SalaryDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\EmployeeAttendance;
use App\Imports\EmployeeAttendanceImport;
use App\Department;
use App\Process;
use App\Helpers\Helper;

use function foo\func;

class ManageSalaryController extends Controller
{
    public function index(Request $request)
    {
        $active = 'manage-salary';
        return view('admin.payroll.manageSalary.index', compact('active'));
    }


    public function salaryHistory(Request $request)
    {

//        $validator = Validator::make($request->all(), [
//            'division_id' => 'required',
//            'center_id' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            foreach ($validator->errors()->all() as $message) {
//                toastr()->error($message);
//            }
//            return redirect()->back()->withInput();
//        }

        $active = 'salary-history';
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');
        $employmentTypes = EmploymentType::all();
        $employeeStatus = EmployeeStatus::all();
        $divisions = Division::with('centers')->get();
        $centers = ($request->has('division_id') && $request->has('center_id')) ? Center::where('division_id', $request->get('division_id'))->get() : [];

        // if(!$request->has('division_id') && !$request->has('center_id')){
        //     $salary_history = [];
        //     return view('admin.payroll.manageSalary.history', compact(
        //         'active',
        //         'salary_history',
        //         'employmentTypes',
        //         'employeeStatus',
        //         'divisions',
        //         'centers',
        //         'month',
        //         'year'
        //     ));
        // }

        $salary_history = salaryHistory::where('month', $year.'-'.$month)
            ->when($request->get('division_id'), function ($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->select(['id', 'employer_id', 'first_name', 'last_name', 'gender'])->withoutGlobalScope(DivisionCenterScope::class)->divisionCenter($request->input('division_id'), $request->input('center_id'));
                });
            })
            ->when($request->get('employment_type_id'),function($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->select(['id', 'employer_id', 'first_name', 'last_name', 'gender'])->whereHas('employeeJourney', function ($q) use ($request){
                        $q->where('employment_type_id', $request->get('employment_type_id'));
                    });
                });
            })
            ->when($request->get('employee_status_id'),function($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->select(['id', 'employer_id', 'first_name', 'last_name', 'gender'])->whereHas('employeeJourney', function ($q) use ($request){
                        $q->where('employee_status_id', $request->get('employee_status_id'));
                    });
                });
            })
            ->when($request->get('employee_id'),function($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->select(['id', 'employer_id', 'first_name', 'last_name', 'gender'])->where('id', $request->get('employee_id'));
                });
            })
            ->where('employee_id', Auth::user()->employee_id)
            ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.employeeJourney.employeeStatus', 'salaryDetails', 'salaryGeneratedBreakdowns'])
            ->paginate(10);

//        if (isset($request->date)) {
//            $y = date_format(date_create($request->date), "Y");
//            $m = date_format(date_create($request->date), "m");
//            $salary_history = SalarySummaryHistory::whereYear('month', '=', $y)
//                ->whereMonth('month', '=', $m)->get();
//        } else {
//            $salary_history = SalarySummaryHistory::all();
//        }
        return view('user.payroll.history', compact(
            'active',
            'salary_history',
            'employmentTypes',
            'employeeStatus',
            'divisions',
            'centers',
            'month',
            'year'
        ));
    }

    public function salaryHistoryIndividual(Request $request)
    {
        $active = 'salary-history';

        if (isset($request->date) && isset($request->employee_id)) {
            $y = date_format(date_create($request->date), "Y");
            $m = date_format(date_create($request->date), "m");
            $salary_history = salaryHistory::whereYear('month', '=', $y)
                ->whereMonth('month', '=', $m)->where('employee_id', $request->employee_id)->get();
        } else if (isset($request->date)) {
            $y = date_format(date_create($request->date), "Y");
            $m = date_format(date_create($request->date), "m");
            $salary_history = salaryHistory::whereYear('month', '=', $y)
                ->whereMonth('month', '=', $m)->get();
        } else if (isset($request->employee_id)) {
            $salary_history = salaryHistory::where('employee_id', $request->employee_id)->get();
        } else {
            $salary_history = salaryHistory::all();
        }

        $emoloyees = Employee::all();
        return view('admin.payroll.manageSalary.individual-history', compact('active', 'salary_history', 'emoloyees'));
    }

    public function paySlipView($id, $type)
    {
        $pageName       =   '';
        $is_download    =   false;
        if($type == EmploymentTypeStatus::PERMANENT || $type == EmploymentTypeStatus::PROBATION){
            $pageName = 'pay-slip-view';
            $salaryBreakdown = $this->preparedPaySlipDataForPermanent($id);
            return view('admin.payroll.manageSalary.'.$pageName, compact('salaryBreakdown', 'id', 'type', 'is_download'));
        }

        if($type == EmploymentTypeStatus::HOURLY){
            $pageName = 'pay-slip-view-hourly';
            // $salaryBreakdown = $this->preparedPaySlipDataForHourly($id);
        }

        if($type == EmploymentTypeStatus::CONTRACTUAL){
            $pageName = 'pay-slip-view-contractual';
            // $salaryBreakdown = $this->preparedPaySlipDataForContractual($id);
        }
        $salary_data = SalaryHistory::find($id);
        if($salary_data){
            $payslip_data       =   json_decode($salary_data->payslip);
            $allowance_data     =   json_decode($payslip_data->allowance_data);
            $adjustment_data    =   json_decode($payslip_data->adjustment_data);
            $salaryBreakdown    =   json_decode($payslip_data->breakdown);
            $employee           =   Employee::find($payslip_data->employee_id);
            $bankInfo           =   array(
                'name'=> $salary_data->employee->individualSalary->bankInfo->bank_name ?? '',
                'account' => $salary_data->employee->individualSalary->bank_account ?? ''
            );
        } else {
            return true;
        }
        // dd($bankInfo);
        // dd($employee);
        // dd($payslip_data);
        // dd($allowance_data);
        // dd($salaryBreakdown);
        // dd($salary_data);
        return view('admin.payroll.manageSalary.'.$pageName, compact('employee', 'salary_data', 'bankInfo', 'salaryBreakdown', 'payslip_data', 'allowance_data', 'adjustment_data', 'id', 'type', 'is_download'));
    }


    public function downloadPaySlip($id, $type)
    {
        $pageName       =   '';
        $is_download    =   true;
        if($type == EmploymentTypeStatus::PERMANENT || $type == EmploymentTypeStatus::PROBATION){
            $pageName = 'pay-slip-view';
            $salaryBreakdown = $this->preparedPaySlipDataForPermanent($id);
            $pdf = PDF::loadView('admin.payroll.manageSalary.'.$pageName, compact('salaryBreakdown', 'is_download'));
            return $pdf->download('payslip.pdf');
        }

        if($type == EmploymentTypeStatus::HOURLY){
            $pageName = 'pay-slip-view-hourly';
        }
        if($type == EmploymentTypeStatus::CONTRACTUAL){
            $pageName = 'pay-slip-view-contractual';
        }

        $salary_data = SalaryHistory::find($id);
        if($salary_data){
            $payslip_data       =   json_decode($salary_data->payslip);
            $allowance_data     =   json_decode($payslip_data->allowance_data);
            $adjustment_data    =   json_decode($payslip_data->adjustment_data);
            $salaryBreakdown    =   json_decode($payslip_data->breakdown);
            $employee           =   Employee::find($payslip_data->employee_id);
            $bankInfo           =   array(
                'name'=> $salary_data->employee->individualSalary->bankInfo->bank_name ?? '',
                'account' => $salary_data->employee->individualSalary->bank_account ?? ''
            );
        } else {
            return true;
        }
        $pdf = PDF::loadView('admin.payroll.manageSalary.'.$pageName, compact('employee', 'salary_data', 'bankInfo', 'salaryBreakdown', 'payslip_data', 'allowance_data', 'adjustment_data', 'id', 'type', 'is_download'));
        return $pdf->download('payslip.pdf');
    }

    public function preparedPaySlipDataForPermanent($id)
    {
        $salary = SalaryHistory::with(['employee', 'employee.individualSalary'=>function($s){ $s->where('salary_status', 1); }, 'salaryDetails', 'salaryGeneratedBreakdowns'])->find($id);
//        dd($salary);
        $yearMonth = Carbon::create($salary->month)->format('Y-m');
        $exYearMonth = explode("-",$yearMonth);
        $year = $exYearMonth[0];
        $month = $exYearMonth[1];
        $dt = Carbon::create($year, $month);
        $previousMonth = $dt->subMonth()->format('Y-m');
        $employeeId = $salary->employee_id;

        $salaryBreakdown = [];
        $salaryBreakdown['userInfo'] = [
            'name' => $salary->employee->FullName ?? '',
            'start_date' => Carbon::parse($salary->start_date)->format('M Y') ?? '',
            'end_date' => Carbon::parse($salary->end_date)->format('M Y') ?? '',
            'month' => Carbon::parse($salary->month)->format('M Y') ?? '',
            'gross' => $salary->gross_salary ?? '',
            'payable' => $salary->payable_amount ?? '',
            'is_hole' => $salary->is_hold ?? 0,
            'bankInfo' => [
                'name'=> $salary->employee->individualSalary->bankInfo->bank_name ?? '',
                'account' => $salary->employee->individualSalary->bank_account ?? ''
            ]
        ];

        // Breakdown
        $gndAmount = 0;
        foreach($salary->salaryGeneratedBreakdowns as $data){
            $gndAmount += $data->amount ?? 0;
            $salaryBreakdown['breakdown'][] = [ $data->name, $data->percentage ?? 0, $data->amount ?? 0];
        }

        //Adjustment
        $payrollSalaryDetail = Payroll::SALARYDETAILS;
        foreach($salary->salaryDetails as $data){
            if($data->add_or_deduct == 1){
                $gndAmount += $data->amount ?? 0;
                $salaryBreakdown['adjustment']['add'][array_search($data->salary_details_type, $payrollSalaryDetail)] = $data->amount ?? '';
            }else{
                $gndAmount -= $data->amount ?? 0;
                $salaryBreakdown['adjustment']['deduct'][array_search($data->salary_details_type, $payrollSalaryDetail)] = $data->amount ?? '';
            }
        }

        //Calculate other allowance
        $allowance = 0;
        $individual_other_allowances = DB::table('individual_other_allowances')->select('*')
            ->where('employee_id', $employeeId)
            ->get();
        foreach ($individual_other_allowances as $individual_other_allowance) {
            if ($individual_other_allowance->type == 'addition') {
                $allowance += $individual_other_allowance->amount;
            } else {
                $allowance -= $individual_other_allowance->amount;
            }
        }
        // dd($allowance);


        // calculate KPI
        $kpi_bonus = 0;
        $kpi = DB::table('kpis')->where('employee_id', $employeeId)->where('monthly_date', $previousMonth)->get();
        if (isset($kpi->amount)) {
            $kpi_bonus = $kpi->amount;
        }


        $gndAmount += $allowance + $kpi_bonus;
        $salaryBreakdown['userInfo']['gndAmount'] = $gndAmount;
        return $salaryBreakdown;
    }


    public function preparedPaySlipDataForHourly($id)
    {
        $yearMonth = SalaryHistory::select('month')->find($id)->month;
        $prev_month = date('Y-m', strtotime('-1 months', strtotime($yearMonth)));
        $year = 0;
        $month = 0;
        if(isset($yearMonth)){
            $exYearMonth = explode("-",$yearMonth);
            $year = $exYearMonth[0];
            $month = $exYearMonth[1];
        }else{
            return [];
        }

        $salary = SalaryHistory::with([
            'employee',
            'employee.employeeHour'=>function($p) use($year, $month){
                $p->whereYear('date', $year)->whereMonth('date', $month);
            },
            'employee.kpi'=> function($p) use($prev_month){
                $p->where('monthly_date', $prev_month);
            },
            'employee.adjustment',
            'employee.otherAllowances'
        ])->find($id);


        $salaryBreakdown = [];
        $kpi = DB::table('kpis')->where('employee_id', $salary->employee_id)->where('monthly_date', $prev_month)->first();
        // dd($kpi);
        //$kpi = isset($salary->employee->kpi) ? $salary->employee->kpi->amount : 0;
        $hourlyRate = $salary->employee->individualSalary->hourly_rate ?? 0;
        $salaryBreakdown['userInfo'] = [
            'id' => $salary->employee->employer_id ?? '',
            'name' => $salary->employee->FullName ?? '',
            'start_date' => Carbon::parse($salary->start_date)->format('M Y') ?? '',
            'end_date' => Carbon::parse($salary->end_date)->format('M Y') ?? '',
            'month' => Carbon::parse($salary->month)->format('M Y') ?? '',
            'hourlyRate' => $hourlyRate,
            'is_hole' => $salary->is_hold ?? 0,
            'bankInfo' => [
                'name'=> $salary->employee->individualSalary->bankInfo->bank_name ?? '',
                'account' => $salary->employee->individualSalary->bank_account ?? ''
            ],
            'payable' => $salary->payable_amount,
            //'hourInfo' => ['Ready Hour'=> (int) $salary->employee->employeeHour->ready_hour ?? 0, 'Lag Hour'=> (int) $salary->employee->employeeHour->lag_hour ?? 0],
            //    'kpiInfo' => ['Grad'=> $salary->employee->kpi->grade ?? '', 'Amount'=> $salary->employee->kpi->amount ?? 0]
        ];

        // dd($salaryBreakdown);

        $gndAmount = 0;

        $total_time_count = EmployeeHours::where('employee_id', $salary->employee_id)->selectRaw(' SEC_TO_TIME(SUM( TIME_TO_SEC( `ready_hour` ) ) )  AS ready_hour,  SEC_TO_TIME (SUM( TIME_TO_SEC( `lag_hour` ) ) ) AS lag_hour')->first();
        $total_time = EmployeeHours::where('employee_id', $salary->employee_id)->selectRaw(' SUM( TIME_TO_SEC( `ready_hour` ) )  AS ready_hour,  SUM( TIME_TO_SEC( `lag_hour` ) )  AS lag_hour')->first();
        $hour = 0;
        $min = 0;
        if($total_time){
            $ready = (floor($total_time->ready_hour / 3600) * $hourlyRate)  + ((floor(($total_time->ready_hour / 60) % 60)/60) * $hourlyRate);
            $lag = (floor($total_time->lag_hour / 3600) * $hourlyRate)  + ((floor(($total_time->lag_hour / 60) % 60)/60) * $hourlyRate);
            // $sec = $total_time->ready_hour % 60;
            $salaryBreakdown['userInfo']['hourInfo'] =
                [
                    'ready_hour'=> $total_time_count->ready_hour,
                    'lag_hour'=> $total_time_count->lag_hour,
                    'ready_hour_amount'=> $ready,
                    'lag_hour_amount'=> $lag
                ];
        }




        $salaryBreakdown['userInfo']['kpiInfo']['Amount'] = $kpi->amount ? $kpi->amount : 0;
        $salaryBreakdown['userInfo']['kpiInfo']['Grad'] = $kpi->grade ? $kpi->grade : '-';

        if(isset($salary->employee->adjustment)){
            foreach($salary->employee->adjustment as $data){
                $gndAmount += $data->amount ?? 0;
                $salaryBreakdown['userInfo']['adjustment'][] = ['name'=> $data->adjustmentType->name ?? '', 'type'=> $data->type ?? '', 'amount'=> $data->amount ?? 0];
            }
        }

        if(isset($salary->employee->otherAllowances)){
            foreach($salary->employee->otherAllowances as $data){
                $gndAmount += $data->amount ?? 0;
                $salaryBreakdown['userInfo']['other'][] = ['name'=> $data->adjustmentType->name ?? '', 'type'=> $data->type ?? '', 'amount'=> $data->amount ?? 0];
            }
        }
        $salaryBreakdown['userInfo']['gndAmount'] = $gndAmount;
        //    dd($salaryBreakdown);
        return $salaryBreakdown;
    }


    public function preparedPaySlipDataForContractual($id)
    {
        $salaryHistory = SalaryHistory::select(['month', 'employee_id'])->find($id);
        $yearMonth = Carbon::create($salaryHistory->month)->format('Y-m');
        $exYearMonth = explode("-",$yearMonth);
        $year = $exYearMonth[0];
        $month = $exYearMonth[1];
        $dt = Carbon::create($year, $month);
        $previousMonth = $dt->subMonth()->format('Y-m');
        // You can iterate from 1 to daysInMonth and get all the dates for that month
        $total_days = $dt->daysInMonth;;

        $employeeId = $salaryHistory->employee_id;


        $last_month = date('Y-m', strtotime('-1 months'));
        $salary = SalaryHistory::with([
            'employee',
            'employee.attendanceSummary'=>function($p) use($last_month){
                $p->where('month', $last_month);
            },'employee.individualSalary'=> function($s){
                $s->where('salary_status', 1);
            }
        ])->find($id);

        //    dd($salary);

        $salaryBreakdown = [];

        //$kpi = isset($salary->employee->kpi) ? $salary->employee->kpi->amount : 0;

        $gndAmount = 0;
        $salaryBreakdown['userInfo'] = [
            'id' => $salary->employee->employer_id ?? '',
            'name' => $salary->employee->FullName ?? '',
            'start_date' => Carbon::parse($salary->start_date)->format('M Y') ?? '',
            'end_date' => Carbon::parse($salary->end_date)->format('M Y') ?? '',
            'month' => Carbon::parse($salary->month)->format('M Y') ?? '',
            'hourlyRate' => $salary->employee->individualSalary->hourly_rate ?? 0,
            'is_hole' => $salary->is_hold ?? 0,
            'bankInfo' => [
                'name'=> $salary->employee->individualSalary->bankInfo->bank_name ?? '',
                'account' => $salary->employee->individualSalary->bank_account ?? ''
            ],
            'payable' => $salary->payable_amount,
            //'hourInfo' => ['Ready Hour'=> (int) $salary->employee->employeeHour->ready_hour ?? 0, 'Lag Hour'=> (int) $salary->employee->employeeHour->lag_hour ?? 0],
            // 'kpiInfo' => ['Grad'=> $salary->employee->kpi->grade ?? '', 'Amount'=> $salary->employee->kpi->amount ?? 0]
        ];

        // $last_month = date('Y-m', strtotime('-1 months'));
        // $attendance_summary = EmployeeAttendanceSummary::where('employee_id', $employee_id)->where('month', $last_month)->first();

        if(isset($salary->employee->attendanceSummary)){
            foreach($salary->employee->attendanceSummary as $data){
                $gross_salary = $data->employee->individualSalary->gross_salary;

                $perday_salary = $gross_salary / $total_days;
                $gndAmount += ($data->present * $perday_salary) + ( 2 * ($data->holiday_present * $perday_salary));

                $salaryBreakdown['userInfo']['summary'][] = [
                    'Present'=> number_format($data->present * $perday_salary, 2),
//                    'Holiday'=> $data->holiday ?? '',
                    'Holiday Present'=> number_format( 2 * ($data->holiday_present * $perday_salary), 2),
//                    'Half Day'=> $data->half_day,
//                    'Half day Present'=> $data->half_day_present,
//                    'Week Off'=> $data->weekoff,
//                    'Adjustment Day Off'=> $data->adj_day_off,
//                    'Absent'=> $data->absent,
//                    'LWP'=> $data->lwp
                ];
            }
        }

        // calculate adjustments
        $adj_amount = 0;
        $adjustments = Adjustment::select('*')
            ->where('employee_id', $employeeId)
            ->where('month', $yearMonth)
            ->get();
        foreach ($adjustments as $adjustment) {
            if ($adjustment->type == 'addition') {
                $adj_amount += $adjustment->amount;
            } else {
                $adj_amount -= $adjustment->amount;
            }
        }

//        dd($adjustments);


        // calculate individual_other_allowances
        $allowance = 0;
        $individual_other_allowances = DB::table('individual_other_allowances')->select('*')
            ->where('employee_id', $employeeId)
            ->get();
        foreach ($individual_other_allowances as $individual_other_allowance) {
            if ($individual_other_allowance->type == 'addition') {
                $allowance += $individual_other_allowance->amount;
            } else {
                $allowance -= $individual_other_allowance->amount;
            }
        }


        // calculate KPI
        $kpi = DB::table('kpis')->where('employee_id', $employeeId)->where('monthly_date', $previousMonth)->first();
        $kpi_bonus = 0;
        if($kpi->amount) {
            $kpi_bonus = $kpi->amount;
        }

        // dd($kpi_bonus);

        $gndAmount += $allowance + $kpi_bonus + $adj_amount;


        $salaryBreakdown['userInfo']['kpi'] =  number_format($kpi_bonus, 2);
        $salaryBreakdown['userInfo']['adjustment'] =  number_format($adj_amount, 2);
        $salaryBreakdown['userInfo']['allowance'] =  number_format($allowance, 2);
        $salaryBreakdown['userInfo']['gndAmount'] = number_format($gndAmount, 2);
        return $salaryBreakdown;
    }


    public function preperatePaySlipData($id)
    {
        $salary = SalaryHistory::with('employee', 'employee.individualSalary', 'salaryDetails', 'salaryGeneratedBreakdowns')->find($id);
        $salaryBreakdown = [];



        $salaryBreakdown['userInfo'] = [
            'name' => $salary->employee->FullName ?? '',
            'start_date' => Carbon::parse($salary->start_date)->format('M Y') ?? '',
            'end_date' => Carbon::parse($salary->end_date)->format('M Y') ?? '',
            'month' => Carbon::parse($salary->month)->format('M Y') ?? '',
            'gross' => $salary->gross_salary ?? '',
            'payable' => $salary->payable_amount ?? '',
            'is_hole' => $salary->is_hold ?? 0,
            'bankInfo' => [
                'name'=> $salary->employee->individualSalary->bankInfo->bank_name ?? '',
                'account' => $salary->employee->individualSalary->bank_account ?? ''
            ]
        ];


        foreach($salary->salaryGeneratedBreakdowns as $data){
            $salaryBreakdown['breakdown'][] = [ $data->name, $data->percentage ?? 0, $data->amount ?? 0];
        }

        $payrollSalaryDetail = Payroll::SALARYDETAILS;
        foreach($salary->salaryDetails as $data){
            if($data->add_or_deduct == 1){
                $salaryBreakdown['adjustment']['add'][array_search($data->salary_details_type, $payrollSalaryDetail)] = $data->amount ?? '';
            }else{
                $salaryBreakdown['adjustment']['deduct'][array_search($data->salary_details_type, $payrollSalaryDetail)] = $data->amount ?? '';
            }

        }

        return $salaryBreakdown;
    }

    public function addEmployeeHours(Request $request)
    {
        $active = 'manage-employee-hours';
        return view('user.payroll.employeeHours.add', compact('active'));
    }

    public function editEmployeeHours(Request $request, $id)
    {
        $active = 'manage-employee-hours';
        $hour_info = EmployeeHours::find($id);
        // dd($id);
        return view('user.payroll.employeeHours.add', compact('active', 'hour_info'));
    }

    public function updateEmployeeHour(Request $request)
    {
        if ($request->id) {
            $vals = array(
                'ready_hour' => $request->ready_hour,
                'lag_hour' => $request->lag_hour,
                'remarks' => $request->remarks,
                'updated_by' => auth()->user()->id,
            );
            EmployeeHours::where('id', $request->id)->update($vals);
        } else {
            $vals = array(
                'date' => date('Y-m-d', strtotime($request->date)),
                'employee_id' => $request->employee_id,
                'hour_type' => $request->hour_type,
                'ready_hour' => $request->ready_hour,
                'lag_hour' => $request->lag_hour,
                'created_by' => auth()->user()->id,
            );
            EmployeeHours::insert($vals);
        }
        toastr()->success('Successfully Uploaded !');
        // return redirect()->route('manage.salary.employee.hours');
        return redirect()->back();
    }

    public function employeeHours(Request $request)
    {
        $active = 'manage-employee-hours';
        $departments = Department::all();
        $processes = Process::all();
        $query = EmployeeHours::query()->with('employee');
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paginate = 10;
        $hour_type = array(
            '0' => 'Regular',
            '1' => 'Adjusted',
            '2' => 'Overtime'
        );
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $salary_history = $query->where('employee_id', 0)->paginate($paginate);
            return view('user.payroll.employeeHours.history', compact('active', 'salary_history', 'hour_type', 'startDate', 'endDate', 'departments', 'processes'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history = $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            /* $employee = Employee::where('employer_id', $request->employee_id)->first();
            if ($employee) { */
                $query->where('employer_id', $request->employee_id);
            /* } */
        }
        if ($request->type) {
            $query->where('hour_type', $request->type);
        }

        if($request->department_id){
            $query->whereHas('employee.departmentProcess', function($d) use($request){
                $d->where('department_id', $request->department_id);
            });
        }

        if($request->process_id){
            $query->whereHas('employee.departmentProcess', function($p) use($request){
                $p->where('process_id', $request->process_id);
            });
        }

        if (!empty($request->get('csv'))) {
            $hour_history =  $query->get();
            return (new FastExcel($hour_history))->download('Salary History.csv', function ($hour) {
                $hourType = [0=>'regular',1 => 'adj', 2 => 'ot'];
                return [
                    'Date' => $hour->date,
                    'Agent ID' => $hour->employer_id,
                    'Ready Hour' => $hour->ready_hour,
                    'Lag Hour' => $hour->lag_hour,
                    'Type' => $hourType[$hour->hour_type],
                    'Created at' => $hour->created_at
                ];
            });
        } else {
            $salary_history = $query->paginate(10);
        }
        //dd($salary_history->get());

        return view('user.payroll.employeeHours.history', compact('active', 'salary_history', 'hour_type', 'startDate', 'endDate', 'departments', 'processes'));
    }

    public function employeeHoursClearanceUpdate(Request $request)
    {
        $statDate = Carbon::parse($request->startDate)->format('Y-m-d');
        $endDate = Carbon::parse($request->endDate)->format('Y-m-d');

        $employeeHour = EmployeeHours::whereBetween('date', [$statDate, $endDate])->update(['check_status'=> 1]);
        if($employeeHour){
            $clearance = [
                'module'=> 'Employee Hour',
                'start_date' => $statDate,
                'end_date' => $endDate,
                'remarks' => $request->remarks
            ];
            Clearance::insert($clearance);
        }
        toastr()->success('Successfully Updated');
        return redirect()->back();
    }

    public function employeeHoursUploadView(Request $request)
    {
        $active = 'manage-employee-hours-view';
        return view('user.payroll.employeeHours.upload', compact('active'));
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = [];
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
                $emp_id[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        // $headerArr = ['ac_no', 'Date', 'Clock_In', 'Clock_Out'];
        // foreach($header as $h){

        // }
        return $data;
    }

    public function employeeHoursClearanceView($startDate, $endDate)
    {
        $active = 'manage-employee-hours-view';
        return view('user.payroll.employeeHours.clearance', compact('active', 'startDate', 'endDate'));
    }


    public function importEmployeeHourCsv(Request $request){
        // CSV file extention start
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $validator = Validator::make(
                [
                    'file' => $file,
                    'extension' => strtolower($file->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]
            );
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }
        // CSV file check end


        // Column validation start here..
        $requiredHeaderCoulumnArray = ['date', 'agent_id', 'ready_hour', 'lag_hour', 'remarks']; // Required header column
        $csvHeaderColumnArray = Helper::fetchCSVHeader($file);
        $validateHeader = Helper::validateHeaderRow($csvHeaderColumnArray, $requiredHeaderCoulumnArray); // Filter it through our validation
        if(!$validateHeader){
            return redirect()->back();
        }
        // Column validation start end..


        // Data validation start here ..
        $requiredDataValidationArray = [
            0   => 'required|date|date_format:d-M-y',
            1   => 'required|numeric',
            2   => 'required',
            3   => 'required'
        ];
        $validationMessage = [
            '0.required'    => 'Date column should not be empty!',
            '0.required'    => 'Ddate column\'s data must be date format!',
            '0.date_format' => 'Ddate column\'s data must be dd-mmm-yy format!',
            '1.required'    => 'Agnent columnt\'s should not be empty!',
            '1.numeric'     => 'Agent column\'s data must be number!',
            '2.required'    => 'Ready hour should not be empty!',
            '3.required'    => 'Lag hour should not be empty!'
        ];
        $csvDataColumnsArray = Helper::fetchCSVData($file);
        $validateData       = Helper::validateDataRow($csvDataColumnsArray, $requiredDataValidationArray, $validationMessage);
        if(!$validateData){
            return redirect()->back();
        }
        // Data validation end here ..


        (new EmployeeHourImport(request()->user()->employee_id))->queue($request->file('excel_file'))->chain([
            new NotifyUserOfCompletedEmployeeHourImport(request()->user()),
        ]);

        toastr()->warning('Your data push in the queue. After data upload compilation let you notify!');
        return redirect()->back();
    }



    // public function importEmployeeHourCsv_old_2(Request $request){
    //     set_time_limit(500);

    //     request()->validate([
    //         'excel_file' => 'required|mimes:csv,txt'
    //     ]);

    //     $active = 'manage-employee-hours-view';
    //     // $faildData  = [];
    //     // $successEmp = 0;
    //     // $faildEmp   = 0;

    //     $path = request()->file('excel_file')->getRealPath();
    //     $file = file($path);
    //     $data = array_slice($file, 1);

    //     foreach($data as $key => $row){
    //         $row = explode(",", $row);
    //         // $employee = DB::table('employees')->where('employer_id', $row[1])->first();
    //         // if($employee){
    //             // $successEmp += 1;
    //             $temp = array(
    //                 //'employee_id' =>  $employee->id, /*Null Import*/
    //                 'employer_id'  => $row[1],
    //                 'hour_type'    =>  0,
    //                 'date'         =>  Carbon::parse($row[0])->format('Y-m-d'),
    //                 'ready_hour'   =>  Carbon::parse($row[2])->format('H:i:s'),
    //                 'lag_hour'     =>  Carbon::parse($row[3])->format('H:i:s') ?? Carbon::parse(Carbon::now())->format('H:i:s'),
    //                 'remarks'      =>  'Upload Data',
    //                 'check_status' =>  '0',
    //                 'created_by'   => auth()->user()->employee_id ?? 1,
    //                 'created_at'   => Carbon::parse(Carbon::now())->format('Y-m-d H:i:s')
    //             );
    //             $checkIfExists = EmployeeHours::where('employer_id', $row[1])->where('date', Carbon::parse($row[0])->format('Y-m-d'))->delete();
    //             EmployeeHours::insert($temp);
    //         // }
    //         // else{
    //         //     $faildEmp   += 1;
    //         //     $faildData[] = $row[1];
    //         // }

    //     }
    //     // $faildData = array_unique($faildData);

    //     // return view('user.payroll.employeeHours.faild-employee-list', compact('active','faildData', 'successEmp', 'faildEmp'));

    //     toastr()->success('Done importing');
    //     return redirect()->back();
    // }



    public function importEmployeeHourCsv_old(Request $request)
    {
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $validator = Validator::make(
                [
                    'file' => $file,
                    'extension' => strtolower($file->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]
            );
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }

        // $file  = file($request->excel_file->getRealPath());
        // $data  = array_slice($file, 1);
        // $parts = (array_chunk($data, 1000));

        // foreach($parts as $key=>$part){
        //     $fileName = storage_path('app/pending-csv-files/'.date('y-m-d-H-i-s'.$key.'.csv'));

        //     file_put_contents($fileName, $part);

        // }

        $new_file_name = md5(uniqid()) . '.' . $request->file('excel_file')->getClientOriginalExtension();
        $destinationPath = storage_path('app/import-temp/');
        $path = $request->file('excel_file')->move($destinationPath, $new_file_name);

        Excel::import(new EmployeeHourImport($request), $path);
        unlink($destinationPath.$new_file_name);



        toastr()->success('Successfully Uploaded !');

        EmployeeHours::importToDb();


        return redirect()->route('employee.manage.salary.employee.hours');
    }



     /* Start Employee Attendance Upload */
     public function addEmployeeAttendance(Request $request)
     {
         $active = 'manage-employee-attendance';
         return view('user.payroll.employeeAttendances.add', compact('active'));
     }

     public function saveEmployeeAttendances(Request $request)
     {
         $validator = Validator::make($request->all(),
                 [
                     'employee_id' => 'required',
                     'date' => 'required',
                     'attendance_type' => 'required',
                 ]
             );

         if ($validator->fails()) {
             toastr()->warning('All field are required !');
             return redirect()->back();
         }

         $employeeId = Employee::where('employer_id',$request->employee_id)->first();
         if(is_null($employeeId)){
            toastr()->warning('Not Found Employer ID !');
            return redirect()->back();
         }

         $data = [
             'employee_id' => $employeeId->id,
             'date' => $request->date,
             'status' => $request->attendance_type
         ];

         EmployeeAttendance::insert($data);
         toastr()->success('Successfully Saved !');
         return redirect()->back();
     }

     public function editEmployeeAttendance(Request $request, $id)
     {
         $active = 'manage-employee-attendance';
         $hour_info = EmployeeAttendance::find($id);
         return view('user.payroll.employeeAttendances.edit', compact('active', 'hour_info', 'id'));
     }

     public function updateEmployeeAttendance(Request $request)
     {
         $employeeId = Employee::where('employer_id',$request->employee_id)->first();
         if ($request->id) {
             $vals = array(
                 'employee_id' => $employeeId->id,
                 'date' => $request->date,
                 'status' => $request->attendance_type,
                 'updated_by' => auth()->user()->id,
             );
             EmployeeAttendance::where('id', $request->id)->update($vals);
         }
         toastr()->success('Successfully Uploaded !');
         // return redirect()->route('manage.salary.employee.hours');
         return redirect()->back();
     }

     public function employeeAttendance(Request $request)
     {
         $active     =   'manage-employee-attendance';
         $query      =   EmployeeAttendance::query()->with('employee');
         $startDate  =   $request->start_date;
         $endDate    =   $request->end_date;

        //  For Clearance start
         $clearanceStatus = Clearance::where('module', 'Employee Attendance')
                ->whereDate('start_date', Carbon::parse($startDate)->format('Y-m-d'))
                ->whereDate('end_date', Carbon::parse($endDate)->format('Y-m-d'))
                ->first();

         $clearance = [];
         if(!empty($clearanceStatus)){
            $clearance['flag'] = false;
         }else{
            $clearance['flag'] = true;
         }
         //  For Clearance End

         $paginate   =   10;
         $attendance_type  =   array(
             \App\Utils\AttendanceStatus::CASUAL_LEAVE => 'Casual Leave',
             \App\Utils\AttendanceStatus::SICK_LEAVE => 'Sick Leave',
             \App\Utils\AttendanceStatus::EARNED_LEAVE => 'Earned Leave',
             \App\Utils\AttendanceStatus::MATERNITY_LEAVE => 'Maternity Leave',
             \App\Utils\AttendanceStatus::PATERNITY_LEAVE => 'Paternity Leave',
             \App\Utils\AttendanceStatus::LEAVE_WITHOUT_PAY => 'Leave Without Pay',
             \App\Utils\AttendanceStatus::PRESENT => 'Present',
             \App\Utils\AttendanceStatus::WITHOUT_ROSTER => 'Without Roster',
             \App\Utils\AttendanceStatus::HOLIDAY => 'Holly Day',
             \App\Utils\AttendanceStatus::DAYOFF => 'Day Off',
             \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF => 'Adjustment Day Off',
             \App\Utils\AttendanceStatus::LATE => 'Late',
             \App\Utils\AttendanceStatus::EARLY_LEAVE => 'Early Leave',
             \App\Utils\AttendanceStatus::ANNUAL_LEAVE => 'Annual Leave',
             \App\Utils\AttendanceStatus::CASUAL_LEAVE_HALF => 'Casual Leave Half',
             \App\Utils\AttendanceStatus::ANNUAL_LEAVE_HALF => 'Annual Leave Half',
             \App\Utils\AttendanceStatus::OUT_OF_OFFICE => 'Out of Offce',
             \App\Utils\AttendanceStatus::HALF_DAY => 'Half Day'
         );
         $requestCheck   =   $request->all();
         if (!$requestCheck) {
             $salary_history =   $query->paginate($paginate);
             return view('user.payroll.employeeAttendances.history', compact('active', 'salary_history', 'attendance_type', 'startDate', 'endDate', 'clearance'));
         }
         if ($startDate && $endDate) {
             $from = date('Y-m-d', strtotime($startDate));
             $to = date('Y-m-d', strtotime($endDate));
             $salary_history =   $query->whereBetween('date', [$from, $to]);
         }
         if ($request->employee_id) {
             /* $employee   =   Employee::where('employer_id', $request->employee_id)->first();
             if ($employee) { */
                 $query->where('employer_id', $request->employee_id);
            /*  } */
         }
         if ($request->attendance_type) {
             $query->where('status', $request->attendance_type);
         }
         $salary_history     =   $query->paginate($paginate);
         return view('user.payroll.employeeAttendances.history', compact('active', 'salary_history', 'attendance_type', 'startDate', 'endDate', 'clearance'));
     }

     public function employeeAttendancesClearanceUpdate(Request $request)
     {
         $statDate = Carbon::parse($request->startDate)->format('Y-m-d');
         $endDate = Carbon::parse($request->endDate)->format('Y-m-d');

         $employeeHour = EmployeeAttendance::whereBetween('date', [$statDate, $endDate])->update(['check_status'=> 1]);
         if($employeeHour){
             $clearance = [
                 'module'=> 'Employee Attendance',
                 'start_date' => $statDate,
                 'end_date' => $endDate,
                 'remarks' => $request->remarks
             ];
             Clearance::insert($clearance);
         }
         toastr()->success('Successfully Updated');
         return redirect()->back();
     }

     public function employeeAttendanceUploadView(Request $request)
     {
         $active = 'manage-employee-attendance-view';
         return view('user.payroll.employeeAttendances.upload', compact('active'));
     }


     public function employeeAttendanceClearanceView($startDate, $endDate)
     {
         $active = 'manage-employee-attendance-view';
         return view('user.payroll.employeeAttendances.clearance', compact('active', 'startDate', 'endDate'));
     }

     public function employeeAttendanceClearanceUpdate(Request $request)
     {
        $statDate = Carbon::parse($request->startDate)->format('Y-m-d');
        $endDate = Carbon::parse($request->endDate)->format('Y-m-d');

        $employeeHour = EmployeeAttendance::whereBetween('date', [$statDate, $endDate])->update(['check_status'=> 1]);
        if($employeeHour){
            $clearance = [
                'module'=> 'Employee Attendance',
                'start_date' => $statDate,
                'end_date' => $endDate,
                'remarks' => $request->remarks
            ];
            Clearance::insert($clearance);
        }
        toastr()->success('Successfully Updated');
        return redirect()->back();
     }

     public function importEmployeeAttendanceCsv(Request $request)
     {
        // CSV file extention start
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $validator = Validator::make(
                [
                    'file' => $file,
                    'extension' => strtolower($file->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]
            );
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }
        // CSV file check end


        // Column validation start here..
        $requiredHeaderCoulumnArray = ['empid', 'date', 'attendance_status']; // Required header column
        $csvHeaderColumnArray = Helper::fetchCSVHeader($file);
        $validateHeader = Helper::validateHeaderRow($csvHeaderColumnArray, $requiredHeaderCoulumnArray); // Filter it through our validation
        if(!$validateHeader){
            return redirect()->back();
        }
        // Column validation start end..


        // Data validation start here ..
        $requiredDataValidationArray = [
            0   => 'required|numeric',
            1   => 'required|date|date_format:d-M-y',
            2   => 'required'
        ];
        $validationMessage = [
            '0.required'    => 'EmpID columnt\'s should not be empty!',
            '0.numeric'     => 'EmpID column\'s data must be number!',
            '1.required'    => 'DATE column\'s should not be empty',
            '1.date'        => 'Date column\'s data must be date format!',
            '1.date_format' => 'Date column\'s data must be dd-mmm-yy format!',
            '2.required'    => 'Attendance Status should not be empty!'
        ];
        $csvDataColumnsArray = Helper::fetchCSVData($file);
        $validateData       = Helper::validateDataRow($csvDataColumnsArray, $requiredDataValidationArray, $validationMessage);
        if(!$validateData){
            return redirect()->back();
        }
        // Data validation end here ..

        (new EmployeeAttendanceImport(request()->user()->employee_id))->queue($request->file('excel_file'))->chain([
            new NotifyUserOfCompletedEmployeeAttendanceImport(request()->user()),
        ]);

        toastr()->warning('Your data push in the queue. After data upload compilation let you notify!');
        return redirect()->back();

     }

     public function importEmployeeAttendanceCsv_old_2(Request $request)
    {

        set_time_limit(500);

        request()->validate([
            'excel_file' => 'required|mimes:csv,txt'
        ]);

        $active = 'missing-report-employee-attendance-csv';

        $path = request()->file('excel_file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);


        foreach($data as $key => $row){
            $row = explode(",", $row);
                $temp = array(
                    'employer_id'  => $row[1],
                    'date'         => Carbon::parse($row[0])->format('Y-m-d'),
                    'status'       => $row[2],
                    'created_by'   => auth()->user()->employee_id ?? null,
                    'created_at'   => Carbon::parse(Carbon::now())->format('Y-m-d H:i:s')
                );
                EmployeeAttendance::where('employer_id', $row[1])->where('date', Carbon::parse($row[0])->format('Y-m-d'))->delete();
                EmployeeAttendance::insert($temp);

        }

        toastr()->success('Done importing');
        return redirect()->back();

    }

     public function importEmployeeAttendanceCsv_old(Request $request)
     {
         if ($request->hasFile('excel_file')) {
             $file = $request->file('excel_file');
             $validator = Validator::make(
                 [
                     'file' => $file,
                     'extension' => strtolower($file->getClientOriginalExtension()),
                 ],
                 [
                     'file' => 'required',
                     'extension' => 'required|in:csv',
                 ]
             );
         } else {
             toastr()->error('Please select correct file.');
             return redirect()->back();
         }

         if ($validator->fails()) {
             $errors = $validator->errors();
             foreach ($errors->all() as $message) {
                 toastr()->error($message);
             }
             return redirect()->back();
         }

         $new_file_name = md5(uniqid()) . '.' . $request->file('excel_file')->getClientOriginalExtension();
         $destinationPath = storage_path('app/import-temp/');
         $path = $request->file('excel_file')->move($destinationPath, $new_file_name);

         Excel::import(new EmployeeAttendanceImport($request), $path);
         unlink($destinationPath.$new_file_name);

         toastr()->success('Successfully Uploaded !');
         return redirect()->route('employee.manage.salary.employee.attendance');
     }


     public function deleteEmployeeAttendance($id)
     {
         $item = EmployeeAttendance::find($id)->delete();
         toastr()->success('Successfully Deleted !');
         return redirect()->route('employee.manage.salary.employee.attendance');
     }
     /* End Employee Attendance Upload */


}
