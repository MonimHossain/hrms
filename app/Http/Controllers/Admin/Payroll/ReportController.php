<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\BankInfo;
use App\Clearance;
use App\Division;
use App\Employee;
use App\Process;
use App\Utils\TeamMemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\IndividualSalary;
use App\salaryHistory;
use Carbon\Carbon;
use App\EmploymentType;
use App\Utils\EmploymentTypeStatus;
use Rap2hpoutre\FastExcel\FastExcel;
use function foo\func;

class ReportController extends Controller
{

    public function summary(Request $request)
    {
        $active = 'salary-summary';
//        $dependent_modules  = array(
//            'loan' => array(
//                'title'     =>  'Loan Statement',
//                'status'    =>  false
//            ),
//            'adjustment' => array(
//                'title'     =>  'Adjustment Statement',
//                'status'    =>  false
//            ),
//            'pf' => array(
//                'title'     =>  'PF Statement',
//                'status'    =>  false
//            ),
//            'tax' => array(
//                'title'     =>  'Tax Statement',
//                'status'    =>  false
//            ),
//            'salary-hold' => array(
//                'title'     =>  'Salary Hold Statement',
//                'status'    =>  false
//            )
//        );
        if (isset($request->month)) {
            $month = date('m', strtotime($request->month));
            $monthPrev = sprintf("%02d", $month-1);
            $year = date('Y', strtotime($request->month));
        } else {
            $month = date('m');
            $monthPrev = sprintf("%02d", $month-1);
            $year = date('Y');
        }
//        $modules = array_keys($dependent_modules);
//        $clearance = Clearance::whereIn('module', $modules)
//            ->where('month', '=', $year.'-'.$month)->get();
//        foreach ($clearance as $module) {
//            if (isset($dependent_modules[$module->module])) {
//                $dependent_modules[$module->module]['status'] = true;
//            }
//        }
//        $is_valid = true;
//        foreach ($dependent_modules as $module) {
//            if ($module['status'] == false) {
//                $is_valid = $module['status'];
//            }
//        }
//        $salary_history = SalaryHistory::whereYear('month', '=', $year)
//            ->whereMonth('month', '=', $month)->get();
//        $total_cost = 0;
//        foreach ($salary_history as $row) {
//            $total_cost += $row->gross_salary;
//        }
//        $employees = Employee::all();





        //$employeeCount = $salaryHistory->reduce(function ($data, $item){
        //
        //    return $data + $item->employee->count();
        //});
        //$employeeCount = $salaryHistory->unique('employee_id')->count();

        $salaryHistory = salaryHistory::where('month', $year.'-'.$month)
            //->where('is_hold', 0)
            ->whereHas('employee', function ($q) use ($request){
                $q->withoutGlobalScopes();
            })
            ->with(['employee' => function($q){
                $q->withoutGlobalScopes();
            }])->get();

        $salaryHistoryPrev = salaryHistory::where('month', $year.'-'.$monthPrev)
            //->where('is_hold', 0)
            ->whereHas('employee', function ($q) use ($request){
                $q->withoutGlobalScopes();
            })
            ->with(['employee' => function($q){
                $q->withoutGlobalScopes();
            }])->get();

        //$salaryDetails['present-month'] = salaryHistory::where('month', $year.'-'.$month)
        //    ->where('is_hold', 0)
        //    ->whereHas('employee', function ($q) use ($request){
        //        $q->withoutGlobalScopes();
        //    })
        //    ->with(['employee' => function($q){
        //        $q->withoutGlobalScopes();
        //    }])
        //    ->sum('payable_amount');
        $salaryDetails['present-month'] = $salaryHistory
            ->where('is_hold', 0)
            ->sum('payable_amount');


        //$salaryDetails['previous-month'] = salaryHistory::where('month', $year.'-'.strval($month-1))
        //    ->where('is_hold', 0)
        //    ->whereHas('employee', function ($q) use ($request){
        //        $q->withoutGlobalScopes();
        //    })
        //    ->with(['employee' => function($q){
        //        $q->withoutGlobalScopes();
        //    }])
        //    ->sum('payable_amount');

        $salaryDetails['previous-month'] = $salaryHistoryPrev
            ->where('is_hold', 0)
            ->sum('payable_amount');

        //$salaryDetails['previous-month-status'] = salaryHistory::where('month', $year.'-'.$month)
        //    ->where('is_hold', 0)
        //    ->whereHas('employee', function ($q) use ($request){
        //        $q->withoutGlobalScopes();
        //    })
        //    ->with(['employee' => function($q){
        //        $q->withoutGlobalScopes();
        //    }])
        //    ->get();
        $salaryDetails['salary-count'] = $salaryHistory->filter(function ($item) {
            return $item->employee;
        })->count();

        $salaryDetails['salary-prev-count'] = $salaryHistoryPrev->filter(function ($item) {
            return $item->employee;
        })->count();

        //$salaryDetails['present-month-hold'] = salaryHistory::where('month', $year.'-'.$month)
        //    ->where('is_hold', 1)
        //    ->whereHas('employee', function ($q) use ($request){
        //        $q->withoutGlobalScopes();
        //    })
        //    ->with(['employee' => function($q){
        //        $q->withoutGlobalScopes();
        //    }])
        //    ->sum('payable_amount');
        $salaryDetails['present-month-hold'] = $salaryHistory
            ->where('is_hold', 1)
            ->sum('payable_amount');




        //$salaryDetails['previous-month-hold'] = salaryHistory::where('month', $year.'-'.strval($month-1))
        //    ->where('is_hold', 1)
        //    ->whereHas('employee', function ($q) use ($request){
        //        $q->withoutGlobalScopes();
        //    })
        //    ->with(['employee' => function($q){
        //        $q->withoutGlobalScopes();
        //    }])
        //    ->sum('payable_amount');
        $salaryDetails['previous-month-hold'] = $salaryHistoryPrev
            ->where('is_hold', 1)
            ->sum('payable_amount');

        $salaryDetails['salary-hold-count'] = $salaryHistory->where('is_hold', 1)->filter(function ($item) {
            return $item->employee;
        })->count();

        //dd($salaryDetails);


        $employees = Employee::select('id', 'employer_id', 'first_name', 'last_name', 'gender')->withoutGlobalScopes()->with('employeeJourney')->get();

        $employeeCount['total'] = $employees->count();
        $employeeCount['active'] = $employees->filter(function($item){
            return ($item->employeeJourney) && $item->employeeJourney->employee_status_id == 1;
        })->count();
        $employeeCount['inactive'] = $employees->filter(function($item){
            return ($item->employeeJourney) && $item->employeeJourney->employee_status_id == 2;
        })->count();
        $employeeCount['suspended'] = $employees->filter(function($item){
            return ($item->employeeJourney) && $item->employeeJourney->employee_status_id == 3;
        })->count();

        $employeeCount['newJoin'] = $employees->filter(function($item) use ($month, $year){
            return ($item->employeeJourney && $item->employeeJourney->doj) && (Carbon::parse($item->employeeJourney->doj)->format('Y-m') == $year.'-'.$month);
        })->count();


        //dd($employeeCount);
        return view('admin.payroll.manageSalary.summary', compact(
            'active',
            'employeeCount',
            'salaryDetails'
        ));
    }


    public function salaryStatus(Request $request)
    {
        $active = 'payroll-report-salary-status';
        $month = ($request->has('month')) ? $request->input('month') : Carbon::now()->format('m');
        $year = ($request->has('year')) ? $request->input('year') : Carbon::now()->format('Y');

        // $division = Division::where('name', ($this->division) ? $this->division : session()->get('division'))->with('centers')->first();
        // $center = $division->centers->where('center', ($this->center) ? $this->center : session()->get('center'))->first();

        $summary_report = [];

        $salaries = salaryHistory::where('month', $year.'-'.$month)
                                    ->whereHas('employee', function($q){
                                        $q->withoutGlobalScope(DivisionCenterScope::class);
                                    })
                                    // ->where('is_hold', 0)
                                    ->with(['employee', 'employee.individualSalary', 'employee.individualSalary.bankInfo', 'employee.individualSalary.paymentType'])
                                    // ->take(10)
                                    ->get();

        // bankwise
        $bankwise = $salaries->filter(function($item){
                                return $item->is_hold == 0;
                            })
                            ->groupBy(function($item){
                                if($item->employee->individualSalary->bankInfo){
                                    return $item->employee->individualSalary->bankInfo->bank_name;
                                }else{
                                    return 'Untracked';
                                }
                            });

        foreach($bankwise as $key => $salary){

            $array['type'] = $key;
            $array['employee_count'] = $salary->count();
            $array['amount'] = $salary->sum('payable_amount');
            $summary_report[] = $array;

        }

        // Payment type wise (account/cheque)
        $paymentTypeWise = $salaries->filter(function($item){
                                return $item->is_hold == 0;
                            })
                            ->groupBy(function($item){
                                return $item->employee->individualSalary->paymentType->type;
                            });
        foreach($paymentTypeWise as $key => $salary){
            $array['type'] = $key;
            $array['employee_count'] = $salary->count();
            $array['amount'] = $salary->sum('payable_amount');
            $summary_report[] = $array;

        }

        // hold wise
        $holdSalaries = $salaries->filter(function($item){
                                return $item->is_hold == 1;
                            });

        $holdSalaryArray['type'] = "hold";
        $holdSalaryArray['employee_count'] = $holdSalaries->count();
        $holdSalaryArray['amount'] = $holdSalaries->sum('payable_amount');
        $summary_report[] = $holdSalaryArray;

        //dd(array_sum(array_column($summary_report,'amount')));

        // dd($summary_report);
        return view('admin.report.payroll.summary', compact(
            'active',
            'month',
            'year',
            'summary_report'
        ));
    }
    public function processSalaryStatus(Request $request)
    {
        $active = 'payroll-report-process-salary-status';
        $month = ($request->has('month')) ? $request->input('month') : Carbon::now()->format('m');
        $year = ($request->has('year')) ? $request->input('year') : Carbon::now()->format('Y');
        //dd($request->session()->get('division'));
        $divisions = Division::where('name', $request->session()->get('division'))->with('centers')->get();
        $employmentTypes = EmploymentType::all();

        //dd($request->all());
        $processSalarySummary = salaryHistory::where('month', $year.'-'.$month)
            ->whereHas('employee', function ($q) use ($request){
                $q->withoutGlobalScopes()->when($request->get('division_id'), function($q) use ($request){
                    $q->divisionCenter($request->get('division_id'), $request->get('center_id'));
                })->when($request->get('department_id'), function ($q) use ($request){
                    $q->department($request->get('department_id'), null, null);
                })->when($request->get('process_id'), function ($q) use ($request){
                    $q->department(null, $request->get('process_id'), null);
                })->when($request->get('process_segment_id'), function ($q) use ($request){
                    $q->department(null, null, $request->get('process_segment_id'));
                })
                ->when($request->get('employment_type_id'), function ($q) use ($request){
                    $q->whereHas('employeeJourney', function ($q) use ($request) {
                        $q->where('employment_type_id', $request->input('employment_type_id'));
                    });
                });
            })
            ->with(['employee' => function($q){
                $q->withoutGlobalScopes();
            }, 'employee.departmentProcess', 'employee.departmentProcess.process','employee.departmentProcess.teams', 'employee.employeeTeam'])
            //->take(20)
            ->get()
            ->groupBy(function ($item){
                $team = $item->employee->employeeTeam->where('member_type', TeamMemberType::MEMBER)->first();
                if($team){
                    $team_id = $team->team_id;

                    $process = optional($item->employee->departmentProcess->where('team_id', $team_id)->first())->process;
                    if(isset($process->name)){
                        return $process->name;
                    }
                    return 'Untracked';
                }else{
                    return 'Untracked';
                }
            });

        $dataset = [];
        foreach ($processSalarySummary as $key => $item){
            $data['Name'] = $key;
            $data['employeeCount'] = $item->count('employee_id');
            $data['amount'] = $item->sum('payable_amount');
            $dataset[] = $data;
        }

        //dd($dataset);
        //dd($processSalarySummary);

        return view('admin.report.payroll.process', compact(
            'active',
            'month',
            'year',
            'employmentTypes',
            //'processes',
            'divisions',
            'dataset'
        ));
    }
    public function bankSalaryStatus(Request $request)
    {
        $active = 'payroll-report-bank-salary-status';
        // $month = ($request->has('month')) ? $request->input('month') : Carbon::now()->format('m');
        // $year = ($request->has('year')) ? $request->input('year') : Carbon::now()->format('Y');
        $month = ($request->has('month')) ? $request->input('month') : '';
        $year = ($request->has('year')) ? $request->input('year') : '';
        $banks = BankInfo::all();
        $salaries = salaryHistory::where('month', $year.'-'.$month)
                                    // ->where('is_hold', 0)
                                    ->whereHas('employee', function($q){
                                        $q->withoutGlobalScope(DivisionCenterScope::class);
                                    })
                                    ->when($request->input('bank_id'), function($q) use ($request) {
                                        $q->whereHas('employee', function($q) use ($request){
                                            $q->withoutGlobalScope(DivisionCenterScope::class)->whereHas('individualSalary', function($q) use ($request){
                                                $q->where('bank_info_id', $request->input('bank_id'));
                                            });
                                        });
                                    })
                                    ->with(['employee', 'employee.individualSalary', 'employee.individualSalary.bankInfo'])
                                    ->get();
                                    // ->paginate(10);
//                                    ->reduce(function($data, $item){
//                                        $array['employee_id'] = $item->employee_id;
//                                        $array['employee_name'] = $item->employee->FullName;
//                                        $array['payable'] = $item->payable_amount;
//                                        $array['account'] = $item->employee->individualSalary->bank_account;
//                                        $array['bank'] = $item->employee->individualSalary->bankInfo->bank_name;
//                                        $array['hold'] = ($item->is_hold) ? 'Yes' : 'No';
//
//                                        $data[] = collect($array);
//                                        return collect($data);
//                                    });
        // dd($salaries);
        return view('admin.report.payroll.bank', compact(
            'active',
            'month',
            'year',
            'banks',
            'salaries'
        ));
    }
    public function holdSalaryStatus(Request $request)
    {
        $active = 'payroll-report-hold-salary-status';
        $month = ($request->has('month')) ? $request->input('month') : Carbon::now()->format('m');
        $year = ($request->has('year')) ? $request->input('year') : Carbon::now()->format('Y');
        $salaries = salaryHistory::where('month', $year.'-'.$month)
            ->whereHas('employee', function ($q) {
                $q->withoutGlobalScope(DivisionCenterScope::class);
            })
            ->where('is_hold', 1)
            ->with(['employee', 'employee.individualSalary', 'employee.individualSalary.bankInfo'])
            // ->paginate(10);
            ->get();
        return view('admin.report.payroll.hold', compact(
            'active',
            'month',
            'year',
            'salaries'
        ));
    }
    public function chequeSalaryStatus(Request $request)
    {
        $active = 'payroll-report-cheque-salary-status';
        $month = ($request->has('month')) ? $request->input('month') : Carbon::now()->format('m');
        $year = ($request->has('year')) ? $request->input('year') : Carbon::now()->format('Y');
        $salaries = salaryHistory::where('month', $year.'-'.$month)
            ->whereHas('employee', function($q) {
                $q->withoutGlobalScope(DivisionCenterScope::class)->whereHas('individualSalary', function($q) {
                    $q->where('payment_type_id', 3);
                });
            })
            ->with(['employee', 'employee.individualSalary', 'employee.individualSalary.bankInfo'])
            ->paginate(10);
        return view('admin.report.payroll.cheque', compact(
            'active',
            'month',
            'year',
            'salaries'
        ));
    }
    public function allSalaryStatus(Request $request)
    {
        $active = 'payroll-report-all-salary-status';
        $month = ($request->has('month')) ? $request->input('month') : Carbon::now()->format('m');
        $year = ($request->has('year')) ? $request->input('year') : Carbon::now()->format('Y');
        $salaries = salaryHistory::where('month', $year.'-'.$month)
            ->whereHas('employee', function ($q) {
                $q->withoutGlobalScope(DivisionCenterScope::class);
            })
            ->with(['employee', 'employee.individualSalary', 'employee.individualSalary.bankInfo'])
            ->get();
            // ->paginate(10);
        return view('admin.report.payroll.all', compact(
            'active',
            'month',
            'year',
            'salaries'
        ));
    }

    public function missingSalarySettings(Request $request)
    {
        $active = 'payroll-report-missing-salary-settings';
        $employment_type = $request->input('employment_type');
        $employment_types = EmploymentType::all();
        $emoloyee_list = Employee::doesntHave('individualSalary')
                    ->when($request->input('employee_id'), function ($q) use ($request) {
                        $q->where('id', $request->input('employee_id'));
                    })
                    ->when(!$request->input('employee_id'), function ($q) use ($request, $employment_type) {
                        $q->whereHas('employeeJourney', function($q) use ($employment_type){
                            if($employment_type){
                                $q->where('employment_type_id', $employment_type);
                            }
                            $q->where('employee_status_id', 1);
                        });
                    })
                    ->with(['employeeJourney', 'employeeJourney.employmentType', 'employeeJourney.designation', 'employeeJourney.employeeStatus', 'divisionCenters', 'divisionCenters.division', 'divisionCenters.center', 'departmentProcess', 'departmentProcess.department', 'departmentProcess.process', 'departmentProcess.processSegment','departmentProcess.teams', 'employeeTeam']);
        if($request->has('csv')){
            $emoloyee_list = $emoloyee_list->get();
            $employeeData = [];
            foreach ($emoloyee_list as $leaveData) {
                $department = [];
                $process_segment = [];
                $division_center = [];
                $employee = $leaveData;
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
                    'Employee Status' => $employee->employeeJourney->employeeStatus->status ?? '',
                    'Joining Date' => $employee->employeeJourney->doj ?? ''
                );
                array_push($employeeData, $data);
            }
            return (new FastExcel($employeeData))->download('missing_salary_info.csv');
        } else {
            $emoloyee_list = $emoloyee_list->paginate(10);
        }
        return view('admin.report.payroll.missing-settings', compact(
            'active',
            'emoloyee_list',
            'employment_types'
        ));
    }
}
