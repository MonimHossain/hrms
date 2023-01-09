<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Adjustment;
use App\AdjustmentType;
use App\BankBranch;
use App\BankInfo;
use App\Center;
use App\EmployeeStatus;
use App\Imports\EmployeeHourImport;
use App\Imports\EmployeeAttendanceImport;
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
use App\Scopes\ActiveEmployeeScope;
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
use App\EmployeeAttendanceSummary;
use App\Kpi;
use App\Http\Controllers\Controller;
use App\Leave;
use App\Holiday;
use App\Services\GenerateSalaryService;
use App\Services\PayrollService;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\Payroll;
use DB;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Rap2hpoutre\FastExcel\FastExcel;
use Validator;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use App\SalaryDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\EmployeeAttendance;
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

    public function salaryLoadForm(Request $request)
    {
        $employee_id = $request->employee_id;
        $employmentType = Employee::whereId($employee_id)->withoutGlobalScope(ActiveEmployeeScope::class)->first()->employeeJourney->employmentType->type;
        $salary_breakdown_settings = SalaryBreakdownSetting::orderBy('is_basic', 'desc')->get();
        $tax_settings = TaxSetting::all();
        $pf_settings = ProvidentFundSetting::first();
        $pay_cycles = PayCycle::all();
        $payment_types = PaymentType::all();
        $banks = BankInfo::all();
        $adjustment_types = AdjustmentType::all();
        $salary_type = $request->input('salary_type');
        if ($salary_type == 0) {
            return view('admin.payroll.manageSalary.salary-form-hourly', compact('employee_id', 'salary_breakdown_settings', 'tax_settings', 'pf_settings', 'employmentType', 'pay_cycles', 'payment_types', 'banks', 'adjustment_types', 'salary_type'));
        } elseif ($salary_type == 1) {
            return view('admin.payroll.manageSalary.salary-form', compact('employee_id', 'salary_breakdown_settings', 'tax_settings', 'pf_settings', 'employmentType', 'pay_cycles', 'payment_types', 'banks', 'adjustment_types', 'salary_type'));
        }
    }

    public function getBank($id)
    {
        return BankInfo::where('id', $id)->first();
    }

    public function getBranch($id)
    {
        return BankBranch::where('bank_id', $id)->get();
    }
    public function getBranchByBranchId($id)
    {
        return BankBranch::where('id', $id)->first();
    }

    public function createEmployeeSalary(Request $request)
    {
        // dd($request->all());
        // validation
        $validator = Validator::make(
            $request->all(),
            [
                'employee_id' => 'required',
                'payment_type_id' => 'required',
                'pay_cycle_id' => 'required',
                'bank_info_id' => 'required_if:payment_type_id,1',
                'bank_branch_id' => 'required_if:payment_type_id,1',
                'bank_account_type' => 'required_if:payment_type_id,1',
                'bank_account' => 'required_if:payment_type_id,1',
                'type' => 'required',
                'applicable_from' => 'required',
                'overtime_status' => 'required',
                'kpi_status' => 'required',
                'kpi_rate' => 'required_if:kpi_status,1',
                'hourly_rate' => 'required_if:type,0',
                'gross_salary' => 'required_if:type,1',
                'total_deduction' => 'required_if:type,1',
                'payable' => 'required_if:type,1',
                'amount' => 'nullable',
            ],
            [
                'required_if' => 'The :attribute field is required.'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }

        // dd($request->all());
        DB::beginTransaction(); // db transaction begins

        try {
            $employee = Employee::where('id', $request->input('employee_id'))->withoutGlobalScope(ActiveEmployeeScope::class)->with(['employeeJourney', 'employeeJourney.employmentType'])->first();
            $employeeExistSalary = IndividualSalary::where('employee_id', $request->input('employee_id'))->where('salary_status', 1)->latest()->first();

            if ($request->input('type') == 1) {
                $employeeSalary = new IndividualSalary();
                $employeeSalary->employee_id = $request->input('employee_id');
                $employeeSalary->payment_type_id = $request->input('payment_type_id');
                $employeeSalary->pay_cycle_id = $request->input('pay_cycle_id');
                $employeeSalary->bank_info_id = $request->input('bank_info_id');
                $employeeSalary->bank_branch_id = $request->input('bank_branch_id');
                $employeeSalary->bank_account = $request->input('bank_account');
                $employeeSalary->bank_account_type = $request->input('bank_account_type');
                $employeeSalary->type = $request->input('type');
                $employeeSalary->overtime_status = $request->input('overtime_status');
                $employeeSalary->kpi_status = $request->input('kpi_status');
                $employeeSalary->kpi_rate = $request->input('kpi_rate');
                $employeeSalary->applicable_from = Carbon::parse($request->input('applicable_from'))->format('Y-m-d');
                $employeeSalary->gross_salary = $request->input('gross_salary');
                $employeeSalary->pf = $request->input('pf');
                $employeeSalary->tax = $request->input('tax');
                if ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) {
                    $employeeSalary->pf_status = ($request->has('pf_status') && $request->input('pf_status') == 'on') ? 0 : 1;
                    $employeeSalary->tax_status = ($request->has('tax_status') && $request->input('tax_status') == 'on') ? 0 : 1;
                } else {
                    $employeeSalary->pf_status = 0;
                    $employeeSalary->tax_status = 0;
                }
                $employeeSalary->total_deduction = $request->input('total_deduction');
                $employeeSalary->payable = $request->input('payable');
                $employeeSalary->salary_status = 1;
                if ($employeeExistSalary) {
                    $employeeExistSalary->applicable_to = Carbon::parse($request->input('applicable_from'))->subDays(1);
                    $employeeExistSalary->salary_status = 0;
                    $employeeExistSalary->save();
                }
                $employeeSalary->save();

                if ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT && $request->has('allowances_percentage')) {
                    foreach ($request->input('allowances_percentage') as $key => $item) {
                        $individualSalaryBreakdown = new IndividualSalaryBreakdown();
                        $individualSalaryBreakdown->employee_id = $request->input('employee_id');
                        $individualSalaryBreakdown->individual_salary_id = $employeeSalary->id;
                        $individualSalaryBreakdown->name = $request->input('allowances_name')[$key];
                        $individualSalaryBreakdown->percentage = $item;
                        $individualSalaryBreakdown->is_basic = $request->input('allowances_is_basic')[$key];
                        $individualSalaryBreakdown->save();
                        // if($individualSalaryBreakdown->save()){
                        //     $employeeSalary->individualSalaryBreakdowns()->attach($individualSalaryBreakdown->id);
                        // }
                    }
                }
                if ($request->has('other_allowance') && count($request->input('other_allowance')) >= 1) {
                    foreach ($request->input('other_allowance') as $key => $item) {
                        if ($item['adjustment_type_id'] != null && $item['type'] != null && $item['amount'] != null) {
                            $otherAllowance = new IndividualOtherAllowance();
                            $otherAllowance->employee_id = $request->input('employee_id');
                            $otherAllowance->individual_salary_id = $employeeSalary->id;
                            $otherAllowance->adjustment_type_id = $item['adjustment_type_id'];
                            $otherAllowance->type = $item['type'];
                            $otherAllowance->amount = $item['amount'];
                            $otherAllowance->remarks = $item['remarks'];
                            $otherAllowance->save();
                            // if($otherAllowance->save()){
                            //     $employeeSalary->individualOtherAllowances()->attach($otherAllowance->id);
                            // }
                        }
                    }
                }
            } elseif ($request->input('type') == 0) {
                $employeeSalary = new IndividualSalary();
                $employeeSalary->employee_id = $request->input('employee_id');
                $employeeSalary->payment_type_id = $request->input('payment_type_id');
                $employeeSalary->pay_cycle_id = $request->input('pay_cycle_id');
                $employeeSalary->bank_info_id = $request->input('bank_info_id');
                $employeeSalary->bank_branch_id = $request->input('bank_branch_id');
                $employeeSalary->bank_account = $request->input('bank_account');
                $employeeSalary->bank_account_type = $request->input('bank_account_type');
                $employeeSalary->type = $request->input('type');
                $employeeSalary->applicable_from = Carbon::parse($request->input('applicable_from'))->format('Y-m-d');
                $employeeSalary->hourly_rate = $request->input('hourly_rate');
                $employeeSalary->pf_status = 0;
                $employeeSalary->tax_status = 0;
                $employeeSalary->salary_status = 1;
                if ($employeeExistSalary) {
                    $employeeExistSalary->applicable_to = Carbon::parse($request->input('applicable_from'))->subDays(1);
                    $employeeExistSalary->salary_status = 0;
                    $employeeExistSalary->save();
                }
                $employeeSalary->save();

                if ($request->has('other_allowance') && count($request->input('other_allowance')) >= 1) {
                    foreach ($request->input('other_allowance') as $key => $item) {
                        if ($item['adjustment_type_id'] != null && $item['type'] != null && $item['amount'] != null) {
                            $otherAllowance = new IndividualOtherAllowance();
                            $otherAllowance->employee_id = $request->input('employee_id');
                            $otherAllowance->individual_salary_id = $employeeSalary->id;
                            $otherAllowance->adjustment_type_id = $item['adjustment_type_id'];
                            $otherAllowance->type = $item['type'];
                            $otherAllowance->amount = $item['amount'];
                            $otherAllowance->remarks = $item['remarks'];
                            $otherAllowance->save();
                            // if($otherAllowance->save()){
                            //     $employeeSalary->individualOtherAllowances()->attach($otherAllowance->id);
                            // }
                        }
                    }
                }
            }

            DB::commit(); // transaction commit

            toastr()->success('Salary created Successfully.');
            return redirect()->route('manage.salary.list.view');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            toastr()->error('Salary not created Successfully. Please check the inputs.');
            return redirect()->back();
        }
    }

    public function salaryList(Request $request)
    {
        $active = 'manage-salary';
        // $employeeSalary = IndividualSalary::where('employee_id', 16)->first();
        // $salarylist = IndividualSalary::where('employee_id', 16)->where('salary_status', 1)->with(['individualSalaryBreakdowns', 'individualOtherAllowances', 'employee', 'bankInfo', 'bankBranch', 'paymentType', 'payCycle'])->first();
        // dd($salarylist->getIndividualSalaryWithIncrement());
        return view('admin.payroll.manageSalary.salary-list', compact('active'));
    }

    // salary list api
    public function salaryListData(Request $request)
    {
        if (!empty($request->get('search'))) {
            $salarylist = IndividualSalary::where('salary_status', 1)
                //->where('employee_id', 'like', '%' . $request->get('search') . '%')
                //->where(function ($q) use ($request){
                //    $q->whereHas('employee', function ($q) use ($request){
                //        $q
                //            //->withoutGlobalScopes()
                //            ->where('first_name', 'like', '%' . $request->get('search') . '%')
                //            ->orWhere('employer_id', 'like', '%' . $request->get('search') . '%');
                //    });
                //})
                ->whereHas('employee', function ($q) use ($request){
                    $q->where(function($q) use ($request){
                        $q->where('first_name', 'like', '%' . $request->get('search') . '%')
                            ->orWhere('employer_id', 'like', '%' . $request->get('search') . '%');
                    })
                        ->withoutGlobalScope(ActiveEmployeeScope::class);

                })
                ->with(['individualSalaryBreakdowns', 'individualOtherAllowances','employee', 'bankInfo', 'bankBranch', 'paymentType', 'payCycle', 'incrementSalaryActive']);

        }else{
            $salarylist = IndividualSalary::where('salary_status', 1)
                ->whereHas('employee', function ($q){
                    return $q->withoutGlobalScope(ActiveEmployeeScope::class);
                })
                ->with(['individualSalaryBreakdowns', 'individualOtherAllowances','employee', 'employee','bankInfo', 'bankBranch', 'paymentType', 'payCycle', 'incrementSalaryActive']);
        }

        return DataTables::of($salarylist)
           ->addColumn('employer_id', function ($salarylist) {

               if($salarylist->employee){
                    return optional($salarylist->employee)->employer_id ?? null;
               } else {
                    $employee = Employee::where('id', $salarylist->employee_id)->withoutGlobalScope(ActiveEmployeeScope::class)->first();
                        //->withoutGlobalScopes()

                    $salarylist->employee = $employee;
                    return $salarylist->employee->employer_id;

               }
            //    return $salarylist->employee->employer_id;

           })
            ->addColumn('name', function ($salarylist) {
                //return '<a href="#" class="kt-media kt-media--sm kt-media--circle" title=""><img src="https://keenthemes.com/metronic/themes/metronic/theme/default/demo1/dist/assets/media/users/100_1.jpg" alt="image"></a>'.' '.$employees->first_name.' '.$employees->last_name;
                $user = [];
//                $user['name'] =  $salarylist->employee->first_name ?? "-". ' ' . $salarylist->employee->last_name ??  "-";
                $user['id'] =  $salarylist->employee->id;
                $user['name'] =  $salarylist->employee->first_name ?? "-";
                $user['image'] = $salarylist->employee->profile_image ?? null;
                $user['gender'] = $salarylist->employee->gender ?? null;
                return $user;
            })
            ->addColumn('paymentType', function ($salarylist) {
                return optional($salarylist->paymentType)->type;
            })
            ->addColumn('payCycle', function ($salarylist) {
                return optional($salarylist->payCycle)->name;
            })
            ->addColumn('bankInfo', function ($salarylist) {
                return optional($salarylist->bankInfo)->bank_name;
            })
            ->addColumn('bankBranch', function ($salarylist) {
                return optional($salarylist->bankBranch)->bank_branch_name;
            })
            ->addColumn('type', function ($salarylist) {
                return ($salarylist->type == 0) ? 'Hourly' : 'Fixed';
            })
            ->addColumn('accountType', function ($salarylist) {
                return ($salarylist->bank_account_type == 1) ? 'Prepaid/Payroll' : (($salarylist->bank_account_type == 2) ? 'Account' : '');
            })
            ->addColumn('hourlyRate', function ($salarylist) {
                $salary = $salarylist->getIndividualSalaryWithIncrement();
                return $salary->hourly_rate;
            })
            ->addColumn('grossSalary', function ($salarylist) {
                $salary = $salarylist->getIndividualSalaryWithIncrement();
                return $salary->gross_salary;
            })
            ->addColumn('payable', function ($salarylist) {
                $salary = $salarylist->getIndividualSalaryWithIncrement();

                if(!$salarylist->employee){
                    $employee = Employee::where('id', $salarylist->employee_id)->withoutGlobalScope(ActiveEmployeeScope::class)->first();
                    $salarylist->employee = $employee;
               }
            //    dd($salarylist->employee->employeeJourney->employment_type_id);
                if($salarylist->employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PROBATION || $salarylist->employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT){

                    if(auth()->user()->hasPermissionTo(_permission(Permissions::MANGE_PERMANENT_SALARY_SETUP_VIEW))){
                        // dd($salary);
                        if($salary->hourly_rate){
                            return $salary->hourly_rate;
                        } else {
                            return $salary->gross_salary;
                        }
                        return $salary->payable;

                    }else{
                        return "Don't have permission";
                    }

                }else{
                    if($salary->hourly_rate){
                        return $salary->hourly_rate;
                    } else {
                        return $salary->gross_salary;
                    }
                    return $salary->payable;
                }

            })
            ->addColumn('pfInfo', function ($salarylist) {
                $salary = $salarylist->getIndividualSalaryWithIncrement();
                return $salary->pf;
            })
            ->addColumn('taxInfo', function ($salarylist) {
                $salary = $salarylist->getIndividualSalaryWithIncrement();
                return $salary->tax;
            })
            ->addColumn('kpirate', function ($salarylist) {
                if($salarylist->employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PROBATION || $salarylist->employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT){
                    if(auth()->user()->hasPermissionTo(_permission(Permissions::MANGE_PERMANENT_SALARY_SETUP_VIEW))){
                        $kpirate =  ($salarylist->kpi_status == 1) ? $salarylist->kpi_rate : '-';
                    }else{
                        return "Don't have permission";
                    }
                }else{
                    $kpirate =  ($salarylist->kpi_status == 1) ? $salarylist->kpi_rate : '-';
                }

                return $kpirate;
            })
            ->addColumn('status', function ($salarylist) {
                return ($salarylist->salary_status == 1) ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($salarylist) {



                $edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_SALARY_EDIT)) ?  auth()->user()->hasPermissionTo(_permission(Permissions::MANGE_PERMANENT_SALARY_SETUP_VIEW))  ? '<a target="_blank" href="' . route('manage.salary.update.form', ['id' => $salarylist->employee_id, 'salary_id' => $salarylist->id]) . '" class="editor_edit"><i class="flaticon-edit"></i></a>' : null : null;
                $increment = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_SALARY_CREATE)) ?  auth()->user()->hasPermissionTo(_permission(Permissions::MANGE_PERMANENT_SALARY_SETUP_VIEW)) ? '<a target="_blank" href="' . route('manage.salary.increment.view', ['id' => $salarylist->employee_id, 'salary_id' => $salarylist->id]) . '" class="editor_edit"><i class="flaticon-diagram"></i></a>' : null : null;
               
               
                return $edit . (($edit && $increment) ? (' / ' . $increment) : $increment);
            })
            ->make(true);
    }

    public function salaryListQuery(Request $request){
        $salarylist = IndividualSalary::where('salary_status', 1)
            // ->select('id', 'employee_id', 'salary_status', 'gross_salary', 'hourly_rate', 'kpi_rate', 'bank_account_type', 'type')
            ->when($request->get('search'), function ($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->where(function($q) use ($request){
                        $q->where('first_name', 'like', '%' . $request->get('search') . '%')
                            ->orWhere('employer_id', 'like', '%' . $request->get('search') . '%');
                    })
                    ->withoutGlobalScope(ActiveEmployeeScope::class);
                });
            }, function ($q) use ($request){
                $q->whereHas('employee', function ($q){
                    return $q->withoutGlobalScope(ActiveEmployeeScope::class);
                });
            })
            ->with(['individualSalaryBreakdowns', 'individualOtherAllowances','employee', 'bankInfo', 'bankBranch', 'paymentType', 'payCycle', 'incrementSalaryActive'])
            //->take(5)
            ->get()
            ->map(function ($item){
                //$item->bank_info_id = $item->bankInfo->bank_name;
                //$item->bank_branch_id = $item->bankBranch->bank_branch_name;
                //$item->payment_type_id = $item->paymentType->type;
                //$item->pay_cycle_id = $item->payCycle->name;
                $item->bank_account_type = ($item->bank_account_type == 1) ? "Prepaid/Payroll" : (($item->bank_account_type == 2) ? "Account" : null);
                $item->type = ($item->type == 1) ? "Hourly" : ( ($item->type == 0) ? "Fixed" : null);
                return $item;
            });
        $list = [];
        foreach($salarylist as $salary){
            $salary_status = ($salary->salary_status == 1) ? 'Active' : 'Inactive';
            $kpi_amount = ($salary->kpi_status == 1) ? $salary->kpi_rate : '-';
            $account_type = $salary->bank_account_type;
            $employee = Employee::withoutGlobalScopes()->find($salary->employee_id);
            $employement_type = $employee->employeeJourney->employmentType->type;
            $payable = $salary->getIndividualSalaryWithIncrement();
            if($payable->hourly_rate){
                $payable = $payable->hourly_rate;
            } else {
                $payable = $payable->gross_salary;
            }
            $temp = array(
                'employer_id' => $employee->employer_id,
                'name' =>  $employee->first_name .' '. $employee->last_name,
                'paymentType' => optional($salary->paymentType)->type,
                'payCycle' => optional($salary->payCycle)->name,
                'bankInfo' => optional($salary->bankInfo)->bank_name,
                'bankBranch' => optional($salary->bankBranch)->bank_branch_name,
                'bank_account' => $salary->bank_account,
                'accountType' => $account_type,
                'type' => ($salary->type == 0) ? 'Hourly' : 'Fixed',
                'applicable_from' => $salary->applicable_from,
                'payable' => $payable,
                'kpirate' => $kpi_amount,
                'status' =>  $salary_status
            );

            array_push($list, $temp);
        }

        // dd($list);
        return $list;
        // return ($salarylist->toArray());
    }

    public function updateSalaryForm($id, $salary_id)
    {
        $active = 'manage-salary';
        $employee_id = $id;
        $employee = Employee::whereId($employee_id)->withoutGlobalScope(ActiveEmployeeScope::class)->first();
        $employmentType = $employee ? $employee->employeeJourney->employmentType->type : '';
        // $salary_breakdown_settings = IndividualSalaryBreakdown::where('employee_id', $employee_id)->orderBy('is_basic', 'desc')->get();
        $tax_settings = TaxSetting::all();
        $pf_settings = ProvidentFundSetting::first();
        $pay_cycles = PayCycle::all();
        $payment_types = PaymentType::all();
        $banks = BankInfo::all();
        $adjustment_types = AdjustmentType::all();
        $salaryInfo = IndividualSalary::whereId($salary_id)->with(['employee', 'bankInfo', 'bankBranch', 'paymentType', 'payCycle'])->first()->getIndividualSalaryWithIncrement();
        $isEditable = $salaryInfo->incrementSalary()->where('salary_status', 1)->exists();
        $branches = BankBranch::where('bank_id', $salaryInfo->bank_info_id)->get();
        $branch = BankBranch::where('id', $salaryInfo->bank_branch_id)->first();
        // $otherAllowance = IndividualOtherAllowance::where('employee_id', $employee_id)->get();

        if ($salaryInfo->type == 0) {
            return view('admin.payroll.manageSalary.salary-edit-hourly', compact('active', 'employee_id', 'salary_id', 'tax_settings', 'pf_settings', 'employmentType', 'pay_cycles', 'payment_types', 'banks', 'branches', 'branch', 'salaryInfo', 'isEditable', 'adjustment_types'));
        } elseif ($salaryInfo->type == 1) {
            return view('admin.payroll.manageSalary.salary-edit', compact('active', 'employee_id', 'salary_id', 'tax_settings', 'pf_settings', 'employmentType', 'pay_cycles', 'payment_types', 'banks', 'branches', 'branch', 'salaryInfo', 'isEditable', 'adjustment_types'));
        }
    }

    public function updateEmployeeSalary(Request $request)
    {
        // validation
        $validator = Validator::make(
            $request->all(),
            [
                'employee_id' => 'required',
                'payment_type_id' => 'required',
                'pay_cycle_id' => 'required',
                'bank_info_id' => 'required_if:payment_type_id,1',
                'bank_branch_id' => 'required_if:payment_type_id,1',
                'bank_account_type' => 'required_if:payment_type_id,1',
                'bank_account' => 'required_if:payment_type_id,1',
                'type' => 'required',
                'applicable_from' => 'required',
                'overtime_status' => 'required',
                'kpi_status' => 'required',
                'kpi_rate' => 'required_if:kpi_status,1',
                'hourly_rate' => 'required_if:type,0',
                'gross_salary' => 'required_if:type,1',
                'total_deduction' => 'required_if:type,1',
                'payable' => 'required_if:type,1',
            ],
            [
                'required_if' => 'The :attribute field is required.'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        DB::beginTransaction(); // db transaction begins

        try {
            $employee = Employee::where('id', $request->input('employee_id'))->withoutGlobalScope(ActiveEmployeeScope::class)->with(['employeeJourney', 'employeeJourney.employmentType'])->first();

            $employeeSalary = IndividualSalary::where('id', $request->input('salary_id'))->where('employee_id', $request->input('employee_id'))->where('salary_status', 1)->first();
            // $incrementSalary = $employeeSalary->incrementSalary()->where('salary_status', 1)->first();
            $incrementSalary = $employeeSalary->incrementSalaryActive->first();



            if ($request->input('type') == 1) {
                // $employeeSalary = IndividualSalary::where('id', $request->input('salary_id'))->where('employee_id', $request->input('employee_id'))->where('salary_status', 1)->first();

                $employeeSalary->employee_id = $request->input('employee_id');
                $employeeSalary->payment_type_id = $request->input('payment_type_id');
                $employeeSalary->pay_cycle_id = $request->input('pay_cycle_id');
                $employeeSalary->bank_info_id = $request->input('bank_info_id');
                $employeeSalary->bank_branch_id = $request->input('bank_branch_id');
                $employeeSalary->bank_account_type = $request->input('bank_account_type');
                $employeeSalary->bank_account = $request->input('bank_account');
                $employeeSalary->type = $request->input('type');
                $employeeSalary->overtime_status = $request->input('overtime_status');
                $employeeSalary->kpi_status = $request->input('kpi_status');
                $employeeSalary->kpi_rate = $request->input('kpi_rate');
                $employeeSalary->applicable_from = Carbon::parse($request->input('applicable_from'))->format('Y-m-d');
                if(!$incrementSalary){
                    $employeeSalary->gross_salary = $request->input('gross_salary');
                    $employeeSalary->pf = $request->input('pf');
                    $employeeSalary->tax = $request->input('tax');
                    // $employeeSalary->pf_status = ($request->has('pf_status') && $request->input('pf_status') == 'on') ? 0 : 1;
                    // $employeeSalary->tax_status = ($request->has('tax_status') && $request->input('tax_status') == 'on') ? 0 : 1;
                    if ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) {
                        $employeeSalary->pf_status = ($request->has('pf_status') && $request->input('pf_status') == 'on') ? 0 : 1;
                        $employeeSalary->tax_status = ($request->has('tax_status') && $request->input('tax_status') == 'on') ? 0 : 1;
                    } else {
                        $employeeSalary->pf_status = 0;
                        $employeeSalary->tax_status = 0;
                    }
                    $employeeSalary->total_deduction = $request->input('total_deduction');
                    $employeeSalary->payable = $request->input('payable');
                    $employeeSalary->salary_status = 1;
                }
                $employeeSalary->save();

                if ($incrementSalary) {
                    if ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) {
                        $incrementSalary->pf_status = ($request->has('pf_status') && $request->input('pf_status') == 'on') ? 0 : 1;
                        $incrementSalary->tax_status = ($request->has('tax_status') && $request->input('tax_status') == 'on') ? 0 : 1;
                    } else {
                        $incrementSalary->pf_status = 0;
                        $incrementSalary->tax_status = 0;
                    }
                    $incrementSalary->save();
                }


                $employeeSalary->individualSalaryBreakdowns()->delete();
                // $employeeSalary->individualSalaryBreakdowns()->detach();
                // IndividualSalaryBreakdown::where('employee_id', $request->input('employee_id'))->delete();
                if ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT && $request->has('allowances_percentage')) {
                    foreach ($request->input('allowances_percentage') as $key => $item) {
                        $individualSalaryBreakdown = new IndividualSalaryBreakdown();
                        $individualSalaryBreakdown->employee_id = $request->input('employee_id');
                        $individualSalaryBreakdown->individual_salary_id = $employeeSalary->id;
                        $individualSalaryBreakdown->name = $request->input('allowances_name')[$key];
                        $individualSalaryBreakdown->percentage = $item;
                        $individualSalaryBreakdown->is_basic = $request->input('allowances_is_basic')[$key];
                        $individualSalaryBreakdown->save();
                        // if($individualSalaryBreakdown->save()){
                        //     $employeeSalary->individualSalaryBreakdowns()->attach($individualSalaryBreakdown->id);
                        // }
                    }
                }

                $employeeSalary->individualOtherAllowances()->delete();
                // $employeeSalary->individualOtherAllowances()->detach();
                // IndividualOtherAllowance::where('employee_id', $request->input('employee_id'))->delete();
                if ($request->has('other_allowance') && count($request->input('other_allowance')) >= 1) {
                    foreach ($request->input('other_allowance') as $key => $item) {
                        if ($item['adjustment_type_id'] != null && $item['type'] != null && $item['amount'] != null) {
                            $otherAllowance = new IndividualOtherAllowance();
                            $otherAllowance->employee_id = $request->input('employee_id');
                            $otherAllowance->individual_salary_id = $employeeSalary->id;
                            $otherAllowance->adjustment_type_id = $item['adjustment_type_id'];
                            $otherAllowance->type = $item['type'];
                            $otherAllowance->amount = $item['amount'];
                            $otherAllowance->remarks = $item['remarks'];
                            $otherAllowance->save();
                            // if($otherAllowance->save()){
                            //     $employeeSalary->individualOtherAllowances()->attach($otherAllowance->id);
                            // }
                        }
                    }
                }
            } elseif ($request->input('type') == 0) {
                // $employeeSalary = IndividualSalary::where('id', $request->input('salary_id'))->where('employee_id', $request->input('employee_id'))->where('salary_status', 1)->first();
                $employeeSalary->employee_id = $request->input('employee_id');
                $employeeSalary->payment_type_id = $request->input('payment_type_id');
                $employeeSalary->pay_cycle_id = $request->input('pay_cycle_id');
                $employeeSalary->bank_info_id = $request->input('bank_info_id');
                $employeeSalary->bank_branch_id = $request->input('bank_branch_id');
                $employeeSalary->bank_account = $request->input('bank_account');
                $employeeSalary->bank_account_type = $request->input('bank_account_type');
                $employeeSalary->type = $request->input('type');
                $employeeSalary->applicable_from = Carbon::parse($request->input('applicable_from'))->format('Y-m-d');
                if(!$incrementSalary) {
                    $employeeSalary->hourly_rate = $request->input('hourly_rate');
                }
                $employeeSalary->pf_status = 0;
                $employeeSalary->tax_status = 0;
                $employeeSalary->salary_status = 1;

                if($employeeSalary->save()){
                    $employeeSalary->individualOtherAllowances()->delete(); // delete previous other allowances
                    // new allowances entry
                    if ($request->has('other_allowance') && count($request->input('other_allowance')) >= 1) {
                        foreach ($request->input('other_allowance') as $key => $item) {
                            if ($item['adjustment_type_id'] != null && $item['type'] != null && $item['amount'] != null) {
                                $otherAllowance = new IndividualOtherAllowance();
                                $otherAllowance->employee_id = $request->input('employee_id');
                                $otherAllowance->individual_salary_id = $employeeSalary->id;
                                $otherAllowance->adjustment_type_id = $item['adjustment_type_id'];
                                $otherAllowance->type = $item['type'];
                                $otherAllowance->amount = $item['amount'];
                                $otherAllowance->remarks = $item['remarks'];
                                $otherAllowance->save();
                            }
                        }
                    }
                }

            }

            DB::commit(); // db transaction commit
            toastr()->success('Salary updated Successfully.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            if($incrementSalary) {
                toastr()->error('Salary amounts can not be updated from here. Employee has incremented salary amount. Update info from increment edit.');
            }
            return redirect()->route('manage.salary.list.view');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            //toastr()->error('Salary not updated. Please check the inputs.');
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function salaryIncrementView($id, $salary_id)
    {
        $active = 'manage-salary';
        $salary = IndividualSalary::whereId($salary_id)->where('employee_id', $id)->first()->getIndividualSalaryWithIncrement();
        // $payrollService = new PayrollService($salary);
        // $incrementSalary = $payrollService->getIndividualSalary($salary);
        // dd($salary);
        // dd($incrementSalary);
        $employee = Employee::find($id);
        return view('admin.payroll.manageSalary.salary-increment', compact('active', 'salary', 'employee'));
    }

    public function salaryIncrementSubmit(Request $request)
    {
        // dd($request->all());
        // validation
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'individual_salary_id' => 'required',
            'type' => 'required',
            'last_hourly_rate' => 'required_if:type,0',
            'current_hourly_rate' => 'required_if:type,0',
            'incremented_hourly_rate' => 'required_if:type,0',
            'last_gross_salary' => 'required_if:type,1',
            'current_gross_salary' => 'required_if:type,1',
            'incremented_amount' => 'required_if:type,1',
            'applicable_from' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }

        $individualSalary = IndividualSalary::whereId($request->input('individual_salary_id'))->first();

        $payrollService = new PayrollService($individualSalary, $request);

        $incrementSalary = $payrollService->incrementSalary();

        // dd($request->all());

        // IndividualSalaryIncrement::create($request->all());
        // if($request->input('type') == 0){
        //     IndividualSalary::whereId($request->input('individual_salary_id'))->where('employee_id', $request->input('employee_id'))->update([
        //         'hourly_rate' => $request->input('current_hourly_rate')
        //     ]);
        // }elseif($request->input('type') == 1){
        //     IndividualSalary::whereId($request->input('individual_salary_id'))->where('employee_id', $request->input('employee_id'))->update([
        //         'gross_salary' => $request->input('current_gross_salary')
        //     ]);
        // }

        if ($incrementSalary) {
            toastr()->success('Salary Incremented Successfully.');
        } else {
            toastr()->error('Something went wrong.');
        }
        return redirect()->route('manage.salary.list.view');
    }

    public function addNewBank()
    {
        $active = 'bank-settings';
        $banks = BankInfo::all();
        return view('admin.payroll.manageSalary.add-bank', compact('active', 'banks'));
    }

    public function addNewBankSubmit(Request $request)
    {
        if (BankInfo::where('bank_name', $request->input('bank_name'))->exists()) {
            toastr()->error('Already Exist.');
            return redirect()->back();
        }

        BankInfo::create($request->all());
        toastr()->success('New bank Added.');
        return redirect()->back();
    }

    public function editBankSubmit(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'edit_bank_name' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        BankInfo::where('id', $request->input('bank_id'))->update([
            'bank_name' => $request->input('edit_bank_name')
        ]);
        toastr()->success('Bank name updated.');
        return redirect()->back();
    }

    public function addNewBranchSubmit(Request $request)
    {
        if (BankBranch::where('bank_id', $request->input('bank_id'))->where('bank_branch_name', $request->input('bank_branch_name'))->exists()) {
            toastr()->error('Already Exist.');
            return redirect()->back();
        }

        BankBranch::create($request->all());
        toastr()->success('New branch Added.');
        return redirect()->back();
    }

    public function editBranchSubmit(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required',
            'edit_branch_name' => 'required',
            'edit_bank_routing' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        BankBranch::where('id', $request->input('branch_id'))->update([
            'bank_branch_name' => $request->input('edit_branch_name'),
            'bank_routing' => $request->input('edit_bank_routing'),
        ]);
        toastr()->success('Branch Info updated.');
        return redirect()->back();
    }

    public function deleteBank(BankInfo $bank)
    {
        if (IndividualSalary::where('bank_info_id', $bank->id)->exists()) {
            toastr()->error('Bank cannot be deleted.');
            return redirect()->back();
        }
        if ($bank->bankBranches()->delete()) {
            $bank->delete();
            toastr()->success('Bank Info deleted.');
        } else {
            toastr()->error('Bank cannot be deleted.');
        }
        return redirect()->back();
    }

    public function generateSalaryConfView(Request $request)
    {
        // $daterange = $request->input('salary_cycle');
        // $start = null;
        // $end = null;
        // if($daterange){
        //     $split = explode(' / ', $daterange);

        //     #check make sure have 2 elements in array
        //     $count = count($split);
        //     if ($count <> 2) {
        //         #invalid data
        //     }
        //     $start = $split[0];
        //     $end = $split[1];
        // }

        $active = 'salary-generate';
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');

        // dd($end_date);
        // dd($request->all());

        if (!empty($request->all())) {
            $generate_salary = true;
        } else {
            $generate_salary = false;
        }

        $employmentTypes = EmploymentType::all();
        $divisions = Division::with('centers')->get();


        $dependent_modules  = array(
            'loan' => array(
                'title'     =>  'Loan Statement',
                'status'    =>  false
            ),
            'adjustment' => array(
                'title'     =>  'Adjustment Statement',
                'status'    =>  false
            ),
            'pf' => array(
                'title'     =>  'PF Statement',
                'status'    =>  false
            ),
            'tax' => array(
                'title'     =>  'Tax Statement',
                'status'    =>  false
            ),
            'salary-hold' => array(
                'title'     =>  'Salary Hold Statement',
                'status'    =>  false
            )
        );

        $modules = array_keys($dependent_modules);

        $clearance = Clearance::whereIn('module', $modules)
            ->where('month', '=', $year.'-'.$month)->get();
        foreach ($clearance as $module) {
            if (isset($dependent_modules[$module->module])) {
                $dependent_modules[$module->module]['status'] = true;
            }
        }
        $is_valid = true;
        foreach ($dependent_modules as $module) {
            if ($module['status'] == false) {
                $is_valid = $module['status'];
            }
        }


        $salaryHistory = SalaryHistory::where('is_hold', 1)->where('month', '=', $year.'-'.$month)->first();
        $releasePreviousHold = [];
        if(!is_null($salaryHistory)){
            $releasePreviousHold = [
                'title'  =>   'Release Previous Hold',
                'month'  =>   $month,
                'year'   =>   $year,
                'status' =>   false,
                'button' =>   true
            ];
        }else{
            $releasePreviousHold = [
                'title'  =>   'Release Previous Hold',
                'month'  =>   $month,
                'year'   =>   $year,
                'status' =>   true,
                'button' =>   false
            ];
        }

        // dd($releasePreviousHold);


        return view('admin.payroll.manageSalary.generate-varification', compact('active', 'dependent_modules', 'is_valid', 'month', 'year', 'generate_salary', 'employmentTypes', 'divisions', 'releasePreviousHold'));
    }

    public function generateFinalSalary(Request $request)
    {
    }

    public function verifySalaryProcess()
    {
        $dependent_modules  = array(
            'loan' => array(
                'title'     =>  'Loan Statement',
                'status'    =>  false
            ),
            'adjustment' => array(
                'title'     =>  'Adjustment Statement',
                'status'    =>  false
            ),
            'pf' => array(
                'title'     =>  'PF Statement',
                'status'    =>  false
            ),
            'tax' => array(
                'title'     =>  'Tax Statement',
                'status'    =>  false
            ),
            'salary-hold' => array(
                'title'     =>  'Salary Hold Statement',
                'status'    =>  false
            )
        );

        $modules = array_keys($dependent_modules);
        $clearance = Clearance::whereIn('module', $modules)
            ->whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('m'))->get();
        foreach ($clearance as $module) {
            if (isset($dependent_modules[$module->module])) {
                $dependent_modules[$module->module]['status'] = true;
            }
        }
        foreach ($dependent_modules as $module) {
            if ($module['status'] == false) {
                return false;
            }
        }
        return true;
    }

    // public function generateSalaryView(Request $request)
    // {


    //     dd($request->all());
    //     // if ($this->verifySalaryProcess() == false) {
    //     //     return redirect()->route('manage.salary.create');
    //     // }
    //     if ($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT) {
    //         $start_date = Carbon::createFromDate($year, $month - 1, 26)->toDateString();
    //         $end_date = Carbon::createFromDate($year, $month, 25)->toDateString();
    //     }

    //     $active    = 'salary-generate';
    //     // employment type
    //     $employmentTypeData = [];
    //     $hold_list          = [];
    //     $salary_list        = [];
    //     $salary_clearance   = [];

    //     $employees = Employee::select(['id', 'employer_id', 'gender'])->with(['employeeJourney', 'employeeJourney.employmentType'])->get();



    //     // salary creation types
    //     foreach (EmploymentType::all() as $empType) {
    //         $hold_list[$empType->type]          =   0;
    //         $salary_list[$empType->type]        =   0;
    //         $salary_clearance[$empType->type]   =   false;
    //         $employmentTypeData[$empType->type] =   0;
    //         $employmentTypeID[$empType->type]   =   [];
    //     }


    //     // getting salary claerance
    //     $salaryClearance = SalarySummaryHistory::whereYear('month', '=', date('Y'))
    //         ->whereMonth('month', '=', date('m'))->with(['employmentType'])->get();
    //     foreach ($salaryClearance as $clearance) {
    //         $salary_clearance[$clearance->employmentType->type] = true;
    //     }


    //     // getting salary hold count
    //     $hold_salary = SalaryHoldList::where('status', 1)
    //         ->whereYear('month', '=', date('Y'))
    //         ->whereMonth('month', '=', date('m'))
    //         ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType'])
    //         ->get();
    //     foreach ($hold_salary as $hold) {
    //         $hold_list[$hold->employee->employeeJourney->employmentType->type]++;
    //     }


    //     // getting salary history count
    //     $salary_history = salaryHistory::whereYear('month', '=', date('Y'))
    //         ->whereMonth('month', '=', date('m'))
    //         ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.individualSalary', 'employee.individualSalary.paymentType', 'employee.individualSalary.incrementSalaryActive']);

    //     $total_salary = $salary_history->get();

    //     foreach ($total_salary as $salary) {
    //         $salary_list[$salary->employee->employeeJourney->employmentType->type]++;
    //     }

    //     // dd($salary_list);

    //     $generated_salary = $salary_history->paginate(50);


    //     if (count($employees)) {
    //         foreach ($employees as $item) {
    //             if (!empty($item->employeeJourney->employmentType)) {
    //                 $employmentTypeData[$item->employeeJourney->employmentType->type] = $employmentTypeData[$item->employeeJourney->employmentType->type] + 1;
    //             }
    //         }
    //     }

    //     // dd($employmentTypeData);

    //     return view('admin.payroll.manageSalary.generate', compact('active', 'employmentTypeData', 'salary_list', 'hold_list', 'salary_clearance', 'generated_salary'));
    // }

    public function generateSalaryView(Request $request)
    {


        // dd($request->all());
        // if ($this->verifySalaryProcess() == false) {
        //     return redirect()->route('manage.salary.create');
        // }

        $active    = 'salary-generate';

        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');

        if ($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT || true) {

            if($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT){
                $start_date = Carbon::createFromDate($year, $month - 1, 26)->toDateString();
                $end_date = Carbon::createFromDate($year, $month, 25)->toDateString();
            } else {
                $start_date = Carbon::createFromDate($year, $month - 1, 16)->toDateString();
                $end_date = Carbon::createFromDate($year, $month, 15)->toDateString();
            }


            // employment type
            $employmentTypeData = [];
            $hold_list          = [];
            $salary_list        = [];
            $salary_clearance   = [];

            $active_employee = Employee::select(['id', 'employer_id', 'gender'])
                ->divisionCenter($request->input('division_id'), $request->input('center_id'))
                ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
                    return  $q->where('employment_type_id', $request->input('employment_type_id'))
                            ->where('employee_status_id', 1);
                })
                ->whereNull('deleted_at')
                ->withoutGlobalScopes()
                ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();

            $closed_employees = Employee::select(['id', 'employer_id', 'gender'])
                ->divisionCenter($request->input('division_id'), $request->input('center_id'))
                ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
                    return  $q->where('employment_type_id', $request->input('employment_type_id'))
                            ->where('employee_status_id', 2)
                            ->whereBetween('lwd', [$start_date,$end_date]);
                })
                ->whereNull('deleted_at')
                ->withoutGlobalScopes()
                ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();

            // dd($closed_employees);
            $employees = $active_employee->merge($closed_employees);
            // dd($employees);
            $employee_list  =   $employees->pluck('id')->toArray();
            // $employees      =   $employees->get();

            // dd($employee_list);


            // salary creation types
            foreach (EmploymentType::all() as $empType) {
                $hold_list[$empType->type]          =   0;
                $salary_list[$empType->type]        =   0;
                $salary_clearance[$empType->type]   =   false;
                $employmentTypeData[$empType->type] =   0;
                $employmentTypeID[$empType->type]   =   [];
            }


            // getting salary claerance
            $salaryClearance = SalarySummaryHistory::whereYear('month', '=', $year)
                ->whereMonth('month', '=', $month)
                ->with(['employmentType'])
                ->get();
            foreach ($salaryClearance as $clearance) {
                $salary_clearance[$clearance->employmentType->type] = true;
            }


            // getting salary hold count
            $hold_salary = SalaryHoldList::where('status', 1)
                ->whereYear('month', '=', $year)
                ->whereMonth('month', '=', $month)
                ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType'])
                ->get();
            foreach ($hold_salary as $hold) {
                $hold_list[$hold->employee->employeeJourney->employmentType->type]++;
            }


            // getting salary history count
            // $salary_history = salaryHistory::whereYear('month', '=', $year)
            //     ->whereMonth('month', '=', $month)
            //     ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.individualSalary', 'employee.individualSalary.paymentType', 'employee.individualSalary.incrementSalaryActive']);

            // dd($employee_list);
            $salary_history = salaryHistory::where('month', '=', Carbon::createFromDate($year, $month)->format('Y-m'))
                ->whereHas('employee', function($q){
                    $q->withoutGlobalScopes();
                })
                ->whereIn('employee_id', $employee_list)
                ->with(['employee' => function($q){
                    $q->withoutGlobalScopes();
                },
                'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.individualSalary', 'employee.individualSalary.paymentType', 'employee.individualSalary.incrementSalaryActive']);

            $total_salary = $salary_history->get();
            $salary_generated_employees = $salary_history->pluck('employee_id')->toArray();

            // dd($salary_generated_employees);
            // dd($employee_list);
            $missing_ids = array_diff($employee_list, $salary_generated_employees);
            $missing_employee_list = Employee::withoutGlobalScopes()->whereIn('id', $missing_ids)->with(['employeeJourney'])->get();
            // dd($missing_employee_list);
            // dd($missing_ids);

            foreach ($total_salary as $salary) {
                if($salary->employee){
                    $salary_list[$salary->employee->employeeJourney->employmentType->type]++;
                }
            }

            // dd($salary_list);
            // $generated_salary = salaryHistory::where('employment_type_id', $request->input('employment_type_id'))->paginate(50);
            $emp_type = $request->input('employment_type_id');
            // $generated_salary = salaryHistory::where('month', '=', Carbon::createFromDate($year, $month)->format('Y-m'))
            //     ->whereHas('employee', function ($q) use ($emp_type){
            //         $q->whereHas('employeeJourney', function ($q) use ($emp_type){
            //             $q->where('employment_type_id', $emp_type);
            //         });
            //     })
            //     ->with([
            //         'employee',
            //         'employee.employeeJourney',
            //         'employee.individualSalary',
            //         'employee.individualSalary.paymentType',
            //         'employee.individualSalary.payCycle',
            //         'employee.individualSalary.bankInfo',
            //         'employee.individualSalary.bankBranch',
            //         'createdBy',
            //         'updatedBy'
            //     ])
            //     ->paginate(50);
            $generated_salary = $salary_history->withoutGlobalScopes()->paginate(50);

            $employementType = EmploymentType::find($request->input('employment_type_id'))->type;
            $employmentTypeData[$employementType] = sizeof($employee_list);
            $salary_list[$employementType] = sizeof($salary_generated_employees);
            // dd($salary_list);
        }else{
            toastr()->error('Others employment type is not ready yet! select permanent only.');
            return redirect()->back();
        }




        // dd($employmentTypeData);

        return view('admin.payroll.manageSalary.generate', compact('active', 'employmentTypeData', 'salary_list', 'hold_list', 'salary_clearance', 'generated_salary', 'missing_employee_list'));
    }

    public function exportSalary(Request $request, $type)
    {
        if ($type == 'Permanent' || true) {
            $employmentType = EmploymentType::where('type', $type)->first();
            // dd($employmentType);
            $m = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
            $y = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');
            // $salary_history = salaryHistory::whereYear('month', '=', $y)
            // ->whereMonth('month', '=', $m)->get();
            // $salary_history = DB::table('salary_history')->select('salary_history.*', 'employees.first_name', 'employees.last_name', 'employees.employer_id', 'creator.first_name as creator_first_name', 'creator.last_name as creator_last_name')
            //     ->leftJoin('employee_journeys', 'employee_journeys.employee_id', '=', 'salary_history.employee_id')
            //     ->leftJoin('employees', 'employees.id', '=', 'salary_history.employee_id')
            //     ->leftJoin('employees as creator', 'employees.id', '=', 'salary_history.created_by')
            //     ->whereYear('salary_history.month', '=', $y)
            //     ->whereMonth('salary_history.month', '=', $m)
            //     ->where('employee_journeys.employment_type_id', $employmentType->id)->get();

            $emp_type = $request->employment_type_id;
            $salary_history = salaryHistory::where('month', '=', Carbon::createFromDate($y, $m)->format('Y-m'))
                ->whereHas('employee', function ($q) use ($emp_type){
                    $q->whereHas('employeeJourney', function ($q) use ($emp_type){
                        $q->where('employment_type_id', $emp_type);
                    });
                })
                ->withoutGlobalScopes()
                ->with([
                    'employee',
                    'employee.employeeJourney',
                    'employee.individualSalary',
                    'employee.individualSalary.paymentType',
                    'employee.individualSalary.payCycle',
                    'employee.individualSalary.bankInfo',
                    'employee.individualSalary.bankBranch',
                    'createdBy',
                    'updatedBy'
                ])
                ->get();
            // dd($salary_history);
            return (new FastExcel($salary_history))->download($type . '.csv', function ($salary) {
                $salary_account_type = '';
                $payment_type = '';
                if (isset($salary->employee->individualSalary->bank_account_type)) {
                    if ($salary->employee->individualSalary->bank_account_type == 1) {
                        $salary_account_type = 'Payroll/Prepaid';
                    } elseif ($salary->employee->individualSalary->bank_account_type == 2) {
                        $salary_account_type = 'Account';
                    }
                }
                if (isset($salary->employee->individualSalary->type)) {
                    if ($salary->employee->individualSalary->type == 0) {
                        $payment_type = 'Hourly';
                    } elseif ($salary->employee->individualSalary->type == 1) {
                        $payment_type = 'Fixed';
                    }
                }
                if ($salary->employee->individualSalary->type == 0) {
                    return [
                        'Employee ID' => $salary->employee->employer_id,
                        'Name' => $salary->employee->FullName,
                        'Month' => $salary->month,
                        'Rate' => $salary->gross_salary,
                        'Payable' => $salary->payable_amount,
                        'Salary Type' => $payment_type,
                        'Payment Type' => $salary->employee->individualSalary->paymentType->type,
                        'Pay Cycle' => $salary->employee->individualSalary->payCycle->name,
                        'Bank' => $salary->employee->individualSalary->bankInfo->bank_name,
                        'Branch' => $salary->employee->individualSalary->bankBranch->bank_branch_name,
                        'Account' => $salary->employee->individualSalary->bank_account,
                        'Account Type' => $salary_account_type,
                        'Status' => $salary->is_hold == 1 ? 'Hold' : 'Paid',
                        'Created by' => ($salary->createdBy) ? $salary->createdBy->FullName : '',
                        'Created at' => $salary->created_at
                    ];
                } elseif ($salary->employee->individualSalary->type == 1) {
                    return [
                        'Employee ID' => $salary->employee->employer_id,
                        'Name' => $salary->employee->FullName,
                        'Month' => $salary->month,
                        'Start Date' => $salary->start_date,
                        'End Date' => $salary->end_date,
                        'Gross Salary' => $salary->gross_salary,
                        'Payable' => $salary->payable_amount,
                        'Salary Type' => $payment_type,
                        'Payment Type' => $salary->employee->individualSalary->paymentType->type,
                        'Pay Cycle' => $salary->employee->individualSalary->payCycle->name,
                        'Bank' => $salary->employee->individualSalary->bankInfo->bank_name,
                        'Branch' => $salary->employee->individualSalary->bankBranch->bank_branch_name,
                        'Account' => $salary->employee->individualSalary->bank_account,
                        'Account Type' => $salary_account_type,
                        'Status' => $salary->is_hold == 1 ? 'Hold' : 'Paid',
                        'Created by' => ($salary->createdBy) ? $salary->createdBy->FullName : '',
                        'Created at' => $salary->created_at
                    ];
                }
            });
        }
    }

    public function clearanceSalary($type)
    {
        // dd($type);
        if ($type == 'Permanent' || true) {
            $employmentType = EmploymentType::where('type', $type)->first();

            $employee   =   Employee::all();
            // employment type
            $employmentTypeData = [];
            $hold_list          = [];
            $salary_list        = [];

            // salary creation types
            $hold_list              =   0;
            $salary_list            =   0;
            $employmentTypeData     =   0;
            $employmentTypeID       =   [];
            $total_salary_amount    =   0;


            // getting salary hold count
            $hold_salary = SalaryHoldList::where('status', 1)
                ->whereYear('month', '=', date('Y'))
                ->whereMonth('month', '=', date('m'))->get();
            foreach ($hold_salary as $hold) {
                if ($employmentType->type == $hold->employee->employeeJourney->employmentType->type) {
                    $hold_list++;
                }
            }

            // getting salary history count
            $total_salary = salaryHistory::whereYear('month', '=', date('Y'))
                ->whereMonth('month', '=', date('m'))->get();

            foreach ($total_salary as $salary) {
                if ($employmentType->type == $salary->employee->employeeJourney->employmentType->type) {
                    $salary_list++;
                    $total_salary_amount += $salary->gross_salary;
                }
            }

            if (count($employee)) {
                foreach ($employee as $item) {
                    if (!empty($item->employeeJourney->employmentType)) {
                        if ($employmentType->type == $item->employeeJourney->employmentType->type) {
                            $employmentTypeData++;
                        }
                    }
                }
            }
            $values = array(
                'employment_type_id' => $employmentType->id,
                'total_amount' => $total_salary_amount,
                'month' => date('Y-m-d'),
                'total_employee' => $employmentTypeData,
                'total_hold' => $hold_list,
                'total_generated' => $salary_list,
                'created_by' => Auth::user()->employee_id,
                'created_at' => date('Y-m-d'),
            );

            SalarySummaryHistory::insert($values);
            return back();
        }
        return back();
    }

    public function generateSalary(Request $request, $type)
    {
        $salaryMonth = "{$request->input('year')}-{$request->input('month')}";
        if ($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT || $request->input('employment_type_id') == EmploymentTypeStatus::PROBATION) {

            $permanentSalary = new GenerateSalaryService($request);
            $generated = $permanentSalary->generatePermanentSalary();
            if ($generated) {
                toastr()->success('Salary generated successfully.');
            } else {
                toastr()->error('Salary generate failed.');
            }
        } else {

            $start_date = Carbon::createFromDate($request->input('year'), $request->input('month') - 1, 16)->toDateString();
            $end_date = Carbon::createFromDate($request->input('year'), $request->input('month'), 15)->toDateString();

            $employmentType = EmploymentType::where('type', $type)->first();
            $active_employee = Employee::select(['id', 'employer_id', 'gender', 'religion'])
                ->divisionCenter($request->input('division_id'), $request->input('center_id'))
                ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
                    return  $q->where('employment_type_id', $request->input('employment_type_id'))
                            ->where('employee_status_id', 1);
                })
                ->whereNull('deleted_at')
                ->withoutGlobalScopes()
                ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();

            $closed_employees = Employee::select(['id', 'employer_id', 'gender', 'religion'])
                ->divisionCenter($request->input('division_id'), $request->input('center_id'))
                ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
                    return  $q->where('employment_type_id', $request->input('employment_type_id'))
                            ->where('employee_status_id', 2)
                            ->whereBetween('lwd', [$start_date,$end_date]);
                })
                ->whereNull('deleted_at')
                ->withoutGlobalScopes()
                ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();
            $employees = $active_employee->merge($closed_employees);
            // dd($employees);
            // $employees = Employee::where('employer_id', 11975)->get();
            // $employees = Employee::where('employer_id', 20011)->get();
            $employeeSalarySummary = [];
            foreach ($employees as $employee) {
                $employeeSalarySummary[$employee->id] = $this->processHourlySalary($employee, $request->input('employment_type_id'), $salaryMonth, $request->all());
                // $employeeSalarySummary[$employee->id] = $this->processHourlySalary($employee->id, $request->input('employment_type_id'), $salaryMonth, $request->all());
            }
        }
        return back();
    }

    public function processHourlySalary($employee, $type, $salaryMonth, $request)
    {
        $employee_id    =   $employee->id;
        $employer_id    =   $employee->employer_id;
        $request        =   (object) $request;
        $salaryMonth    =   $salaryMonth;
        $adj_amount     =   0;
        $allowance      =   0;
        $payable_salary =   0;
        $total          =   0;
        $lwp_amount     =   0;
        $gross_salary   =   0;
        $salary_rate    =   0;
        $payslip        =   [];
        $breakdown      =   [];
        $kpi_bonus      =   0;
        $kpi_grade      =   "";

        $salary_info    =   IndividualSalary::where('employee_id', $employee_id)->withoutGlobalScopes()->first();
        $last_month     =   date('Y-m', strtotime('-1 months', strtotime($salaryMonth)));
        $cycle_start    =   date('Y-m-16', strtotime('-1 months', strtotime($salaryMonth)));
        $cycle_end      =   date('Y-m-15', strtotime($salaryMonth));
        $kpi            =   DB::table('kpis')->where('employer_id', $employer_id)->where('monthly_date', $last_month)->first();

        if($salary_info){

            // Process hourly salary
            if ($salary_info->type == 0) {
                $center         =   Center::find($request->center_id);
                $religion       =   $employee->religion;
                $holidays       =   $center->holidays()->whereJsonContains('religion->religion', [$religion])->whereBetween('start_date', [$cycle_start, $cycle_end])->get();
                $holiday_dates  =   [];
                if($holidays->count()){
                    foreach($holidays as $holiday){
                        $period = CarbonPeriod::create($holiday->start_date, $holiday->end_date);
                        foreach ($period as $date) {
                            array_push($holiday_dates, $date->format('Y-m-d'));
                        }
                    }
                }
                $total_time     =   EmployeeHours::where('employer_id', $employer_id)
                                ->selectRaw(' SUM( TIME_TO_SEC( `ready_hour` ) )  AS ready_hour,  SUM( TIME_TO_SEC( `lag_hour` ) )  AS lag_hour')
                                ->whereBetween('date', [$cycle_start, $cycle_end])
                                ->withoutGlobalScopes()
                                ->first();
                $ot_hours       =   EmployeeHours::where('employer_id', $employer_id)
                                ->selectRaw(' SUM( TIME_TO_SEC( `ready_hour` ) )  AS ready_hour,  SUM( TIME_TO_SEC( `lag_hour` ) )  AS lag_hour')
                                ->whereIn('date', $holiday_dates)
                                ->withoutGlobalScopes()
                                ->first();
                // dd($ot_hours);

                $hour                       =   0;
                $min                        =   0;
                $sec                        =   0;
                $ot_hour                    =   0;
                $ot_min                     =   0;
                $ot_sec                     =   0;
                $break_hour                 =   0;
                $break_min                  =   0;
                $break_sec                  =   0;
                $total_hour                 =   "";
                $total_min                  =   "";
                $total_sec                  =   "";
                $total_break_hour           =   "";
                $total_ready_hour_hour      =   "";
                $total_lag_hour             =   "";
                $total_ot_hour              =   "";
                $total_ready_hour_amount    =   0;
                $total_lag_hour_amount      =   0;
                $total_break_hour_amount    =   0;
                $total_ot_hour_amount       =   0;
                $gross_salary_rate          =   $salary_info->hourly_rate;
                $salary_rate                =   $salary_info->hourly_rate;

                if($total_time){
                    $total_brk_hour_amount  = $total_time->ready_hour * (11/89);
                    $total_hour     = floor(($total_time->ready_hour + $total_brk_hour_amount + $total_time->lag_hour) / 3600);
                    $total_min      = floor(floor(($total_time->ready_hour + $total_brk_hour_amount + $total_time->lag_hour) / 60) % 60);
                    $total_sec      = floor(($total_time->ready_hour + round($total_brk_hour_amount) + $total_time->lag_hour) % 60);

                    $break_hour     = floor(floor($total_brk_hour_amount / 3600));
                    $break_min      = floor(floor(($total_brk_hour_amount / 60) % 60));
                    $break_sec      = round($total_time->ready_hour * (11/89)) % 60;

                    $hour           = floor($total_time->ready_hour / 3600) + floor($total_time->lag_hour / 3600) + floor($break_hour);
                    $min            = floor(($total_time->ready_hour / 60) % 60) + floor(($total_time->lag_hour / 60) % 60) + floor($break_min);
                    $sec            = ($total_time->ready_hour % 60) + ($total_time->lag_hour % 60) + $break_sec;

                    if($ot_hours){
                        $ot_hour    = floor($ot_hours->ready_hour / 3600);
                        $ot_min     = floor(($ot_hours->ready_hour / 60) % 60);
                        $ot_sec    = floor($ot_hours->ready_hour % 60);
                    }

                    $total_ready_hour_amount    =   floor($total_time->ready_hour / 3600) * $gross_salary_rate + (floor(($total_time->ready_hour / 60) % 60)/60) * $gross_salary_rate + (floor($total_time->ready_hour % 60)/3600) * $gross_salary_rate;
                    $total_lag_hour_amount      =   floor($total_time->lag_hour / 3600) * $gross_salary_rate + (floor(($total_time->lag_hour / 60) % 60)/60) * $gross_salary_rate +  + (floor($total_time->lag_hour % 60)/3600) * $gross_salary_rate;
                    $total_break_hour_amount    =   $break_hour * $gross_salary_rate + ($break_min/60) * $gross_salary_rate + ($break_sec / 3600) * $gross_salary_rate;
                    $total_ot_hour_amount       =   $ot_hour * $gross_salary_rate + ($ot_min/60) * $gross_salary_rate + ($ot_sec / 3600) * $gross_salary_rate;

                    $total_hour         =   str_pad($total_hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($total_min, 2, '0', STR_PAD_LEFT) . ":" . str_pad($total_sec, 2, '0', STR_PAD_LEFT);
                    $total_break_hour   =   str_pad($break_hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($break_min, 2, '0', STR_PAD_LEFT) . ":" . str_pad($break_sec, 2, '0', STR_PAD_LEFT);
                    $total_ready_hour   =   str_pad(floor($total_time->ready_hour / 3600), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor(($total_time->ready_hour / 60) % 60), 2, '0', STR_PAD_LEFT)  . ":" . str_pad(floor($total_time->ready_hour % 60), 2, '0', STR_PAD_LEFT);
                    $total_lag_hour     =   str_pad(floor($total_time->lag_hour / 3600), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor(($total_time->lag_hour / 60) % 60), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor($total_time->lag_hour % 60), 2, '0', STR_PAD_LEFT);
                    $total_ot_hour      =   str_pad(floor($ot_hours->ready_hour / 3600), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor(($ot_hours->ready_hour / 60) % 60), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor($ot_hours->ready_hour % 60), 2, '0', STR_PAD_LEFT);
                }
                if (isset($kpi->amount)) {
                    $total_ready_hour_kpi    =   floor($total_time->ready_hour / 3600) * $kpi->amount + (floor(($total_time->ready_hour / 60) % 60)/60) * $kpi->amount + (floor($total_time->ready_hour % 60)/3600) * $kpi->amount;
                    $total_lag_hour_kpi      =   floor($total_time->lag_hour / 3600) * $kpi->amount + (floor(($total_time->lag_hour / 60) % 60)/60) * $kpi->amount + (floor($total_time->lag_hour % 60)/3600) * $kpi->amount;
                    $total_break_hour_kpi    =   $break_hour * $kpi->amount + ($break_min/60) * $kpi->amount + ($break_sec/3600) * $kpi->amount;
                    $total_ot_hour_kpi       =   $ot_hour * $kpi->amount + ($ot_min/60) * $kpi->amount + ($ot_sec/3600) * $kpi->amount;

                    // $kpi_bonus = $kpi->amount;
                    $kpi_bonus = ($total_ready_hour_kpi + $total_lag_hour_kpi + $total_break_hour_kpi + $total_ot_hour_kpi);
                    $kpi_grade = $kpi->grade;
                }
                $total = $total_ready_hour_amount + $total_lag_hour_amount + $total_break_hour_amount + $total_ot_hour_amount + $kpi_bonus;

                $breakdown = array(
                    'month'             => $salaryMonth,
                    'ready_hour'        =>  $total_ready_hour,
                    'ready_hour_amount' =>  $total_ready_hour_amount,
                    'lag_hour'          =>  $total_lag_hour,
                    'lag_hour_amount'   =>  $total_lag_hour_amount,
                    'break_hour'        =>  $total_break_hour,
                    'break_hour_amount' =>  $total_break_hour_amount,
                    'ot_hour'           =>  $total_ot_hour,
                    'ot_hour_amount'    =>  $total_ot_hour_amount,
                    'total_hour'        =>  $total_hour,
                    'kpi_bonus'         =>  $kpi_bonus,
                    'kpi_grade'         =>  $kpi_grade,
                    'salary_rate'       =>  $gross_salary_rate
                );
            } else {

                // Process fixed salary
                $gross_salary           =   0;
                $total_days             =   0;
                $perday_salary          =   0;
                $present                =   0;
                $holiday_present        =   0;
                $halfday                =   0;
                $ado                    =   0;
                $leave                  =   0;
                $work_from_home         =   0;
                $off_day                =   0;
                $govt_holiday           =   0;
                $halfday_on_holiday     =   0;
                $ot_present             =   0;
                $actual_present         =   0;

                // ######### Note: this gets attendance summary #################
                // $employee_attendance    =   EmployeeAttendanceSummary::where('employee_id', $employee_id)->where('month', $last_month)->first();

                // ######### Note: this works gets daily attendance #################
                $employee_attendance    =   EmployeeAttendance::where('employer_id', $employer_id)
                                            ->select(DB::raw('count(status) as total, status'))
                                            ->groupBy('status')
                                            ->withoutGlobalScopes()
                                            ->whereBetween('date', [$cycle_start, $cycle_end])
                                            ->get();
                if($employee_attendance){
                    $gross_salary   =   $salary_info->gross_salary;
                    $salary_rate    =   $salary_info->gross_salary;
                    $dt             =   Carbon::now()->startOfMonth()->subMonth();
                    $total_days     =   22;
                    // $total_days     =   Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                    $perday_salary  =   $gross_salary / $total_days;

                    // ######### Note: this works for attendance summary #################
                    // $present        =   $employee_attendance->present;
                    // $holiday_present=   $employee_attendance->holiday_present;

                    // ######### Note: this works for daily attendance #################
                    foreach($employee_attendance as $attendance_data){
                        if($attendance_data->status == 'HP'){
                            $holiday_present    =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'HDP'){
                            $halfday_on_holiday    =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'P'){
                            $present            =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'HD'){
                            $halfday            =   $attendance_data->total;
                        }
                        // if($attendance_data->status == 'ADO'){
                        //     $ado                =   $attendance_data->total;
                        // }
                        // if($attendance_data->status == 'L'){
                        //     $leave              =   $attendance_data->total;
                        // }
                        if($attendance_data->status == 'W'){
                            $work_from_home     =   $attendance_data->total;
                        }
                        // if($attendance_data->status == 'D'){
                        //     $off_day            =   $attendance_data->total;
                        // }
                        // if($attendance_data->status == 'GH'){
                        //     $govt_holiday       =   $attendance_data->total;
                        // }
                    }
                    $actual_present =   $present + ($halfday * 0.5) + $work_from_home;
                    $ot_present     =   $holiday_present * 2 + ($halfday_on_holiday * 0.5) * 1.5;
                    $present        =   $actual_present + $ot_present;
                    $present_temp   =   $actual_present + $ot_present;
                    // dd($present);
                    $gross_salary   =   ($present * $perday_salary);
                    $present        =   $actual_present + $holiday_present + ($halfday_on_holiday * 0.5);
                    $ot_present     =   $present_temp - $present;
                    // dd($ot_present  * $perday_salary);
                    // dd($gross_salary);
                }
                if (isset($kpi->amount)) {
                    $kpi_bonus = $kpi->amount;
                    $kpi_grade = $kpi->grade;
                }
                $total = $gross_salary + $kpi_bonus;

                $breakdown = array(
                    'month'             =>  $salaryMonth,
                    'gross_salary'      =>  $salary_info->gross_salary,
                    'total_days'        =>  $total_days,
                    'perday_salary'     =>  $perday_salary,
                    'present'           =>  $present,
                    'holiday_present'   =>  $ot_present,
                    'kpi_bonus'         =>  $kpi_bonus,
                    'kpi_grade'         =>  $kpi_grade,
                );
            }

            $lwp_data = [];
            $cycle_start    =   date('Y-m-16', strtotime('-1 months', strtotime($salaryMonth)));
            $cycle_end      =   date('Y-m-15', strtotime($salaryMonth));
            if ($type == EmploymentTypeStatus::CONTRACTUAL) {
                $leaves = DB::table('leaves')->select(DB::raw('SUM(quantity) as total'))
                    ->where('leave_type_id', 6)
                    ->where('leave_status', 1)
                    ->where('employee_id', $employee_id)
                    ->groupBy('leave_type_id')
                    ->havingRaw('SUM(quantity) > ?', [0])
                    ->whereBetween('start_date', [$cycle_start, $cycle_end])
                    ->first();
                if (isset($leaves->total) && $leaves->total > 0) {
                    $dt             =   Carbon::now()->startOfMonth()->subMonth();
                    $total_days     =   Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                    $perday_salary  =   $gross_salary / $total_days;
                    $lwp_amount     =   $leaves->total * $perday_salary;
                    $lwp_data = array(
                        'days' => $leaves->total,
                        'amount' => $lwp_amount
                    );
                }
            }

            if ($type == EmploymentTypeStatus::PROBATION) {

                $cycle_start    =   date('Y-m-d', strtotime('first day of this month', strtotime($salaryMonth)));
                $cycle_end      =   date('Y-m-d', strtotime('last day of this month', $salaryMonth));
                $leaves = DB::table('leaves')->select(DB::raw('SUM(quantity) as total'))
                    ->where('leave_type_id', 6)
                    ->where('leave_status', 1)
                    ->where('employee_id', $employee_id)
                    ->groupBy('leave_type_id')
                    ->havingRaw('SUM(quantity) > ?', [0])
                    ->whereBetween('start_date', [$cycle_start, $cycle_end])
                    ->first();
                if (isset($leaves->total) && $leaves->total > 0) {
                    $dt             =   Carbon::now()->startOfMonth()->subMonth();
                    $total_days     =   Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                    $perday_salary  =   $gross_salary / $total_days;
                    $lwp_amount     =   $leaves->total * $perday_salary;
                    $lwp_data = array(
                        'days' => $leaves->total,
                        'amount' => $lwp_amount
                    );
                }
            }

            $adjustment_addition = [];
            $adjustment_deduction = [];
            $adjustments = Adjustment::where('employer_id', $employer_id)
                ->where('month', $salaryMonth)
                ->withoutGlobalScopes()
                ->get();
            foreach ($adjustments as $adjustment) {
                if ($adjustment->type == 'addition') {
                    $adj_amount += $adjustment->amount;
                    $adjustment_addition[$adjustment->adjustmentType->name] = $adjustment->amount;
                } else {
                    $adj_amount -= $adjustment->amount;
                    $adjustment_deduction[$adjustment->adjustmentType->name] = $adjustment->amount;
                }
            }
            $adjustment_data = array(
                'adjustment_addition'  => json_encode($adjustment_addition),
                'adjustment_deduction'  => json_encode($adjustment_deduction)
            );

            $allowance_addition     =   [];
            $allowance_deduction    =   [];
            $individual_other_allowances    =   IndividualOtherAllowance::where('employee_id', $employee_id)->withoutGlobalScopes()->get();
            foreach ($individual_other_allowances as $individual_other_allowance) {
                if ($individual_other_allowance->type == 'addition') {
                    $allowance += $individual_other_allowance->amount;
                    $allowance_addition[$individual_other_allowance->adjustmentType->name] = $individual_other_allowance->amount;
                } else {
                    $allowance -= $individual_other_allowance->amount;
                    $allowance_deduction[$individual_other_allowance->adjustmentType->name] = $individual_other_allowance->amount;
                }
            }
            $allowance_data = array(
                'allowance_addition'  => json_encode($allowance_addition),
                'allowance_deduction'  => json_encode($allowance_deduction)
            );

            $is_hold = DB::table('salary_hold_lists')
                ->where('employee_id', $employee_id)
                ->where('month', $salaryMonth)
                ->first();

            $payable_salary = $total + $adj_amount + $allowance - $lwp_amount;

            $payslip = array(
                'employee_id'       =>  $employee_id,
                'month'             =>  $salaryMonth,
                'cycle_start'       =>  $cycle_start,
                'cycle_end'         =>  $cycle_end,
                'created_by'        =>  Auth::user()->employee_id,
                'created_at'        =>  date('Y-m-d h:i:s'),
                'breakdown'         =>  json_encode($breakdown),
                'adjustment_data'   =>  json_encode($adjustment_data),
                'allowance_data'    =>  json_encode($allowance_data),
                'lwp_data'          =>  json_encode($lwp_data),
                'payable_salary'    =>  $payable_salary
            );

            $values = array(
                'employee_id'           =>  $employee_id,
                'employment_type_id'    =>  $type,
                'month'                 =>  $salaryMonth,
                'gross_salary'          =>  $salary_rate,
                'payable_amount'        =>  $payable_salary,
                'is_hold'               =>  $is_hold ? 1 : 0,
                'kpi'                   =>  $kpi_bonus,
                'payslip'               =>  json_encode($payslip),
                'created_by'            =>  Auth::user()->employee_id,
                'updated_by'            =>  Auth::user()->employee_id,
                'created_at'            =>  date('Y-m-d h:i:s'),
                'updated_at'            =>  date('Y-m-d h:i:s'),
            );
            salaryHistory::where('employee_id', $employee_id)->withoutGlobalScopes()->where('month', $salaryMonth)->delete();
            salaryHistory::insert($values);
            return true;
        } else {
            return false;
        }
    }

    public function processHourlySalaryOld($employee_id, $type, $salaryMonth, $request)
    {
        $request        =   (object) $request;
        $salaryMonth    =   $salaryMonth;
        $adj_amount     =   0;
        $allowance      =   0;
        $payable_salary =   0;
        $total          =   0;
        $lwp_amount     =   0;
        $gross_salary   =   0;
        $salary_rate    =   0;
        $payslip        =   [];
        $breakdown      =   [];
        $kpi_bonus      =   0;
        $kpi_grade      =   "";

        $salary_info    =   IndividualSalary::where('employee_id', $employee_id)->withoutGlobalScopes()->first();
        $last_month     =   date('Y-m', strtotime('-1 months', strtotime($salaryMonth)));
        $cycle_start    =   date('Y-m-16', strtotime('-1 months', strtotime($salaryMonth)));
        $cycle_end      =   date('Y-m-15', strtotime($salaryMonth));
        $kpi            =   DB::table('kpis')->where('employee_id', $employee_id)->where('monthly_date', $last_month)->first();

        if($salary_info){

            // Process hourly salary
            if ($salary_info->type == 0) {
                $holidays       =   Employee::whereId($employee_id)->with(['divisionCenters' => function($q) {
                                    $q->where('is_main', 1);
                                    }, 'divisionCenters.center', 'divisionCenters.center.holidays'])
                                    ->first();
                $center         =   Center::find($request->center_id);
                $religion       =   'Islam';
                $holidays       =   $center->holidays()->whereJsonContains('religion->religion', [$religion])->where('center_holiday.division_id', $request->division_id)->whereBetween('start_date', [$cycle_start, $cycle_end])->get();
                $holiday_dates  =   [];
                if($holidays->count()){
                    foreach($holidays as $holiday){
                        $period = CarbonPeriod::create($holiday->start_date, $holiday->end_date);
                        foreach ($period as $date) {
                            array_push($holiday_dates, $date->format('Y-m-d'));
                        }
                    }
                }
                $total_time     =   EmployeeHours::where('employee_id', $employee_id)
                                ->selectRaw(' SUM( TIME_TO_SEC( `ready_hour` ) )  AS ready_hour,  SUM( TIME_TO_SEC( `lag_hour` ) )  AS lag_hour')
                                ->whereBetween('date', [$cycle_start, $cycle_end])
                                ->withoutGlobalScopes()
                                ->first();
                $ot_hours       =   EmployeeHours::where('employee_id', $employee_id)
                                ->selectRaw(' SUM( TIME_TO_SEC( `ready_hour` ) )  AS ready_hour,  SUM( TIME_TO_SEC( `lag_hour` ) )  AS lag_hour')
                                ->whereIn('date', $holiday_dates)
                                ->withoutGlobalScopes()
                                ->first();

                $hour                       =   0;
                $min                        =   0;
                $sec                        =   0;
                $ot_hour                    =   0;
                $ot_min                     =   0;
                $ot_sec                     =   0;
                $break_hour                 =   0;
                $break_min                  =   0;
                $break_sec                  =   0;
                $total_hour                 =   "";
                $total_min                  =   "";
                $total_sec                  =   "";
                $total_break_hour           =   "";
                $total_ready_hour_hour      =   "";
                $total_lag_hour             =   "";
                $total_ot_hour              =   "";
                $total_ready_hour_amount    =   0;
                $total_lag_hour_amount      =   0;
                $total_break_hour_amount    =   0;
                $total_ot_hour_amount       =   0;
                $gross_salary_rate          =   $salary_info->hourly_rate;
                $salary_rate                =   $salary_info->hourly_rate;

                if($total_time){
                    $total_brk_hour_amount  = $total_time->ready_hour * (11/89);
                    $total_hour     = floor(($total_time->ready_hour + $total_brk_hour_amount + $total_time->lag_hour) / 3600);
                    $total_min      = floor(floor(($total_time->ready_hour + $total_brk_hour_amount + $total_time->lag_hour) / 60) % 60);
                    $total_sec      = floor(($total_time->ready_hour + round($total_brk_hour_amount) + $total_time->lag_hour) % 60);

                    $break_hour     = floor(floor($total_brk_hour_amount / 3600));
                    $break_min      = floor(floor(($total_brk_hour_amount / 60) % 60));
                    $break_sec      = round($total_time->ready_hour * (11/89)) % 60;

                    $hour           = floor($total_time->ready_hour / 3600) + floor($total_time->lag_hour / 3600) + floor($break_hour);
                    $min            = floor(($total_time->ready_hour / 60) % 60) + floor(($total_time->lag_hour / 60) % 60) + floor($break_min);
                    $sec            = ($total_time->ready_hour % 60) + ($total_time->lag_hour % 60) + $break_sec;

                    if($ot_hours){
                        $ot_hour    = floor($ot_hours->ready_hour / 3600);
                        $ot_min     = floor(($ot_hours->ready_hour / 60) % 60);
                        $ot_sec    = floor($ot_hours->ready_hour % 60);
                    }

                    $total_ready_hour_amount    =   floor($total_time->ready_hour / 3600) * $gross_salary_rate + (floor(($total_time->ready_hour / 60) % 60)/60) * $gross_salary_rate + (floor($total_time->ready_hour % 60)/3600) * $gross_salary_rate;
                    $total_lag_hour_amount      =   floor($total_time->lag_hour / 3600) * $gross_salary_rate + (floor(($total_time->lag_hour / 60) % 60)/60) * $gross_salary_rate +  + (floor($total_time->lag_hour % 60)/3600) * $gross_salary_rate;
                    $total_break_hour_amount    =   $break_hour * $gross_salary_rate + ($break_min/60) * $gross_salary_rate + ($break_sec / 3600) * $gross_salary_rate;
                    $total_ot_hour_amount       =   $ot_hour * $gross_salary_rate + ($ot_min/60) * $gross_salary_rate + ($ot_sec / 3600) * $gross_salary_rate;

                    $total_hour         =   str_pad($total_hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($total_min, 2, '0', STR_PAD_LEFT) . ":" . str_pad($total_sec, 2, '0', STR_PAD_LEFT);
                    $total_break_hour   =   str_pad($break_hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($break_min, 2, '0', STR_PAD_LEFT) . ":" . str_pad($break_sec, 2, '0', STR_PAD_LEFT);
                    $total_ready_hour   =   str_pad(floor($total_time->ready_hour / 3600), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor(($total_time->ready_hour / 60) % 60), 2, '0', STR_PAD_LEFT)  . ":" . str_pad(floor($total_time->ready_hour % 60), 2, '0', STR_PAD_LEFT);
                    $total_lag_hour     =   str_pad(floor($total_time->lag_hour / 3600), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor(($total_time->lag_hour / 60) % 60), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor($total_time->lag_hour % 60), 2, '0', STR_PAD_LEFT);
                    $total_ot_hour      =   str_pad(floor($ot_hours->ready_hour / 3600), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor(($ot_hours->ready_hour / 60) % 60), 2, '0', STR_PAD_LEFT) . ":" . str_pad(floor($ot_hours->ready_hour % 60), 2, '0', STR_PAD_LEFT);
                }
                if (isset($kpi->amount)) {
                    $total_ready_hour_kpi    =   floor($total_time->ready_hour / 3600) * $kpi->amount + (floor(($total_time->ready_hour / 60) % 60)/60) * $kpi->amount + (floor($total_time->ready_hour % 60)/3600) * $kpi->amount;
                    $total_lag_hour_kpi      =   floor($total_time->lag_hour / 3600) * $kpi->amount + (floor(($total_time->lag_hour / 60) % 60)/60) * $kpi->amount + (floor($total_time->lag_hour % 60)/3600) * $kpi->amount;
                    $total_break_hour_kpi    =   $break_hour * $kpi->amount + ($break_min/60) * $kpi->amount + ($break_sec/3600) * $kpi->amount;
                    $total_ot_hour_kpi       =   $ot_hour * $kpi->amount + ($ot_min/60) * $kpi->amount + ($ot_sec/3600) * $kpi->amount;

                    // $kpi_bonus = $kpi->amount;
                    $kpi_bonus = ($total_ready_hour_kpi + $total_lag_hour_kpi + $total_break_hour_kpi + $total_ot_hour_kpi);
                    $kpi_grade = $kpi->grade;
                }
                $total = $total_ready_hour_amount + $total_lag_hour_amount + $total_break_hour_amount + $total_ot_hour_amount + $kpi_bonus;

                $breakdown = array(
                    'month'             => $salaryMonth,
                    'ready_hour'        =>  $total_ready_hour,
                    'ready_hour_amount' =>  $total_ready_hour_amount,
                    'lag_hour'          =>  $total_lag_hour,
                    'lag_hour_amount'   =>  $total_lag_hour_amount,
                    'break_hour'        =>  $total_break_hour,
                    'break_hour_amount' =>  $total_break_hour_amount,
                    'ot_hour'           =>  $total_ot_hour,
                    'ot_hour_amount'    =>  $total_ot_hour_amount,
                    'total_hour'        =>  $total_hour,
                    'kpi_bonus'         =>  $kpi_bonus,
                    'kpi_grade'         =>  $kpi_grade,
                    'salary_rate'       =>  $gross_salary_rate
                );
            } else {

                // Process fixed salary
                $gross_salary           =   0;
                $total_days             =   0;
                $perday_salary          =   0;
                $present                =   0;
                $holiday_present        =   0;
                $halfday                =   0;
                $ado                    =   0;
                $leave                  =   0;
                $work_from_home         =   0;
                $off_day                =   0;
                $govt_holiday           =   0;
                $halfday_on_holiday     =   0;

                // ######### Note: this gets attendance summary #################
                // $employee_attendance    =   EmployeeAttendanceSummary::where('employee_id', $employee_id)->where('month', $last_month)->first();

                // ######### Note: this works gets daily attendance #################
                $employee_attendance    =   EmployeeAttendance::where('employee_id', $employee_id)
                                            ->select(DB::raw('count(status) as total, status'))
                                            ->groupBy('status')
                                            ->withoutGlobalScopes()
                                            ->whereBetween('date', [$cycle_start, $cycle_end])
                                            ->get();
                if($employee_attendance){
                    $gross_salary   =   $salary_info->gross_salary;
                    $salary_rate    =   $salary_info->gross_salary;
                    $dt             =   Carbon::now()->startOfMonth()->subMonth();
                    $total_days     =   Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                    $perday_salary  =   $gross_salary / $total_days;

                    // ######### Note: this works for attendance summary #################
                    // $present        =   $employee_attendance->present;
                    // $holiday_present=   $employee_attendance->holiday_present;

                    // ######### Note: this works for daily attendance #################
                    foreach($employee_attendance as $attendance_data){
                        if($attendance_data->status == 'HP'){
                            $holiday_present    =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'HDP'){
                            $halfday_on_holiday    =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'P'){
                            $present            =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'HD'){
                            $halfday            =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'ADO'){
                            $ado                =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'L'){
                            $leave              =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'W'){
                            $work_from_home     =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'D'){
                            $off_day            =   $attendance_data->total;
                        }
                        if($attendance_data->status == 'GH'){
                            $govt_holiday       =   $attendance_data->total;
                        }
                    }
                    $present        =   $present + ($halfday * 0.5) + $ado + $leave + $work_from_home + $off_day + $govt_holiday;
                    $gross_salary   =   ($present * $perday_salary) + ($holiday_present * $perday_salary) + ($halfday_on_holiday * 1.5);
                }
                if (isset($kpi->amount)) {
                    $kpi_bonus = $kpi->amount;
                    $kpi_grade = $kpi->grade;
                }
                $total = $gross_salary + $kpi_bonus;

                $breakdown = array(
                    'month'             =>  $salaryMonth,
                    'gross_salary'      =>  $salary_info->gross_salary,
                    'total_days'        =>  $total_days,
                    'perday_salary'     =>  $perday_salary,
                    'present'           =>  $present,
                    'holiday_present'   =>  $holiday_present,
                    'kpi_bonus'         =>  $kpi_bonus,
                    'kpi_grade'         =>  $kpi_grade,
                );
            }

            $lwp_data = [];
            $cycle_start    =   date('Y-m-16', strtotime('-1 months', strtotime($salaryMonth)));
            $cycle_end      =   date('Y-m-15', strtotime($salaryMonth));
            if ($type == EmploymentTypeStatus::CONTRACTUAL) {
                $leaves = DB::table('leaves')->select(DB::raw('SUM(quantity) as total'))
                    ->where('leave_type_id', 6)
                    ->where('leave_status', 1)
                    ->where('employee_id', $employee_id)
                    ->groupBy('leave_type_id')
                    ->havingRaw('SUM(quantity) > ?', [0])
                    ->whereBetween('start_date', [$cycle_start, $cycle_end])
                    ->first();
                if (isset($leaves->total) && $leaves->total > 0) {
                    $dt             =   Carbon::now()->startOfMonth()->subMonth();
                    $total_days     =   Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                    $perday_salary  =   $gross_salary / $total_days;
                    $lwp_amount     =   $leaves->total * $perday_salary;
                    $lwp_data = array(
                        'days' => $leaves->total,
                        'amount' => $lwp_amount
                    );
                }
            }

            if ($type == EmploymentTypeStatus::PROBATION) {

                $cycle_start    =   date('Y-m-d', strtotime('first day of this month', strtotime($salaryMonth)));
                $cycle_end      =   date('Y-m-d', strtotime('last day of this month', $salaryMonth));
                $leaves = DB::table('leaves')->select(DB::raw('SUM(quantity) as total'))
                    ->where('leave_type_id', 6)
                    ->where('leave_status', 1)
                    ->where('employee_id', $employee_id)
                    ->groupBy('leave_type_id')
                    ->havingRaw('SUM(quantity) > ?', [0])
                    ->whereBetween('start_date', [$cycle_start, $cycle_end])
                    ->first();
                if (isset($leaves->total) && $leaves->total > 0) {
                    $dt             =   Carbon::now()->startOfMonth()->subMonth();
                    $total_days     =   Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
                    $perday_salary  =   $gross_salary / $total_days;
                    $lwp_amount     =   $leaves->total * $perday_salary;
                    $lwp_data = array(
                        'days' => $leaves->total,
                        'amount' => $lwp_amount
                    );
                }
            }

            $adjustment_addition = [];
            $adjustment_deduction = [];
            $adjustments = Adjustment::where('employee_id', $employee_id)
                ->where('month', $salaryMonth)
                ->withoutGlobalScopes()
                ->get();
            foreach ($adjustments as $adjustment) {
                if ($adjustment->type == 'addition') {
                    $adj_amount += $adjustment->amount;
                    $adjustment_addition[$adjustment->adjustmentType->name] = $adjustment->amount;
                } else {
                    $adj_amount -= $adjustment->amount;
                    $adjustment_deduction[$adjustment->adjustmentType->name] = $adjustment->amount;
                }
            }
            $adjustment_data = array(
                'adjustment_addition'  => json_encode($adjustment_addition),
                'adjustment_deduction'  => json_encode($adjustment_deduction)
            );

            $allowance_addition     =   [];
            $allowance_deduction    =   [];
            $individual_other_allowances    =   IndividualOtherAllowance::where('employee_id', $employee_id)->withoutGlobalScopes()->get();
            foreach ($individual_other_allowances as $individual_other_allowance) {
                if ($individual_other_allowance->type == 'addition') {
                    $allowance += $individual_other_allowance->amount;
                    $allowance_addition[$individual_other_allowance->adjustmentType->name] = $individual_other_allowance->amount;
                } else {
                    $allowance -= $individual_other_allowance->amount;
                    $allowance_deduction[$individual_other_allowance->adjustmentType->name] = $individual_other_allowance->amount;
                }
            }
            $allowance_data = array(
                'allowance_addition'  => json_encode($allowance_addition),
                'allowance_deduction'  => json_encode($allowance_deduction)
            );

            $is_hold = DB::table('salary_hold_lists')
                ->where('employee_id', $employee_id)
                ->where('month', $salaryMonth)
                ->first();

            $payable_salary = $total + $adj_amount + $allowance - $lwp_amount;

            $payslip = array(
                'employee_id'       =>  $employee_id,
                'month'             =>  $salaryMonth,
                'cycle_start'       =>  $cycle_start,
                'cycle_end'         =>  $cycle_end,
                'created_by'        =>  Auth::user()->employee_id,
                'created_at'        =>  date('Y-m-d h:i:s'),
                'breakdown'         =>  json_encode($breakdown),
                'adjustment_data'   =>  json_encode($adjustment_data),
                'allowance_data'    =>  json_encode($allowance_data),
                'lwp_data'          =>  json_encode($lwp_data),
                'payable_salary'    =>  $payable_salary
            );

            $values = array(
                'employee_id'           =>  $employee_id,
                'employment_type_id'    =>  $type,
                'month'                 =>  $salaryMonth,
                'gross_salary'          =>  $salary_rate,
                'payable_amount'        =>  $payable_salary,
                'is_hold'               =>  $is_hold ? 1 : 0,
                'kpi'                   =>  $kpi_bonus,
                'payslip'               =>  json_encode($payslip),
                'created_by'            =>  Auth::user()->employee_id,
                'updated_by'            =>  Auth::user()->employee_id,
                'created_at'            =>  date('Y-m-d h:i:s'),
                'updated_at'            =>  date('Y-m-d h:i:s'),
            );
            salaryHistory::where('employee_id', $employee_id)->withoutGlobalScopes()->where('month', $salaryMonth)->delete();
            salaryHistory::insert($values);
            return true;
        } else {
            return false;
        }
    }

    public function salaryRollback($employee_id)
    {
        $employee_salary = DB::table('employee_journeys')->select('*')
            ->join('individual_salaries', 'individual_salaries.employee_id', '=', 'employee_journeys.employee_id')
            ->where('employee_journeys.employee_status_id', 1)
            ->where('employee_journeys.employee_id', $employee_id)
            ->first();

        if ($employee_salary) {
            $this->reprocessEmployeeSalary($employee_salary);
            return redirect()->route('generate.salary');
        }
    }

    public function salaryRegenerate(Request $request)
    {
        $employee_id = Employee::where('employer_id', $request->employee_id)->first();
        if ($employee_id) {
            $employee_id = $employee_id->id;
            $this->salaryRollback($employee_id);
        }
        return back();
    }

    public function reprocessEmployeeSalary($salary)
    {

        $gross_salary   =   $salary->gross_salary;
        $loan_amount    =   0;
        $pf_amount      =   0;
        $tax_amount     =   0;
        $adj_amount     =   0;
        $lwp_amount     =   0;

        // calculate loan
        $loans = DB::table('loan_applications')->select('loan_emis.*')
            ->join('loan_emis', 'loan_emis.loan_id', '=', 'loan_applications.id')
            ->where('loan_applications.employee_id', $salary->employee_id)
            ->where('loan_applications.status', 2)
            ->where('loan_emis.status', 2)
            ->get();

        foreach ($loans as $loan) {
            $loan_amount += $loan->amount;
            DB::table('loan_emis')->where('id', $loan->id)->update(['status' => 2]);
        }

        // calculate lwp
        $leaves = DB::table('leaves')->select(DB::raw('SUM(quantity) as total'))
            ->where('leave_type_id', 6)
            ->where('leave_status', 1)
            ->groupBy('leave_type_id')
            ->havingRaw('SUM(quantity) > ?', [0])
            ->first();
        if (isset($leaves->total) && $leaves->total > 0) {
            $dt = Carbon::now()->startOfMonth()->subMonth();
            $total_days = Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
            $perday_salary = $gross_salary / $total_days;
            $lwp_amount = $leaves->total * $perday_salary;
        }

        // calculate adjustments
        $adjustments = DB::table('adjustments')->select('*')
            ->where('employee_id', $salary->employee_id)
            ->where('status', 2)
            ->get();
        foreach ($adjustments as $adjustment) {
            if ($adjustment->type == 'addition') {
                $adj_amount += $adjustment->amount;
            } else {
                $adj_amount -= $adjustment->amount;
            }
            DB::table('adjustments')->where('id', $adjustment->id)->update(['status' => 2]);
        }

        // calculate TAX
        $tax = DB::table('tax_histories')->select('*')
            ->where('employee_id', $salary->employee_id)
            ->where('status', 'payed')
            ->first();
        if (isset($tax)) {
            $tax_amount = $tax->amount;
            DB::table('tax_histories')->where('id', $tax->id)->update(['status' => 'payed']);
        }

        // check if hold
        $is_hold = DB::table('salary_hold_lists')
            ->where('employee_id', $salary->employee_id)
            ->whereYear('month', '=', date('Y'))
            ->whereMonth('month', '=', date('m'))->first();


        $payable_salary = $gross_salary - $loan_amount - $pf_amount - $tax_amount - $lwp_amount + $adj_amount;
        $values = array(
            'employee_id' => $salary->employee_id,
            'month' => date('Y-m-d'),
            'gross_salary' => $payable_salary,
            'is_hold' => $is_hold ? 1 : 0,
            'created_by' => Auth::user()->employee_id,
            'updated_by' => Auth::user()->employee_id,
        );
        DB::table('salary_history')->where('employee_id', $salary->employee_id)
            ->whereYear('month', '=', date('Y'))
            ->whereMonth('month', '=', date('m'))->delete();
        DB::table('salary_history')->insert($values);
    }

    public function processEmployeeSalary($employee)
    {
        $individualSalary = $employee->individualSalary->getIndividualSalaryWithIncrement();
        $gross_salary   =   $individualSalary->gross_salary;
        $loan_amount    =   0;
        $pf_amount      =   0;
        $tax_amount     =   0;
        $adj_amount     =   0;
        $lwp_amount     =   0;

        // // calculate loan
        // $loans = DB::table('loan_applications')->select('loan_emis.*')
        //     ->join('loan_emis', 'loan_emis.loan_id', '=', 'loan_applications.id')
        //     ->where('loan_applications.employee_id', $salary->employee_id)
        //     ->where('loan_applications.status', 2)
        //     ->where('loan_emis.status', 2)
        //     ->get();
        // // note: ->where('loan_emis.status', 1)
        // foreach ($loans as $loan) {
        //     $loan_amount += $loan->amount;
        //     DB::table('loan_emis')->where('id', $loan->id)->update(['status' => 2]);
        // }

        // calculate lwp
        $leaves = Leave::select(DB::raw('SUM(quantity) as total'))
            ->where('leave_type_id', 6)
            ->where('leave_status', 1)
            ->groupBy('leave_type_id')
            ->havingRaw('SUM(quantity) > ?', [0])
            ->first();
        if (isset($leaves->total) && $leaves->total > 0) {
            $dt = Carbon::now()->startOfMonth()->subMonth();
            $total_days = Carbon::parse($dt->format('Y-m-d'))->daysInMonth;
            $perday_salary = $gross_salary / $total_days;
            $lwp_amount = $leaves->total * $perday_salary;
        }

        $yearMonth = date('Y-m');
        // calculate adjustments
        $adjustments = Adjustment::where('employee_id', $employee->id)
            ->where('month', $yearMonth)
            ->get();
        foreach ($adjustments as $adjustment) {
            if ($adjustment->type == 'addition') {
                $adj_amount += $adjustment->amount;
            } else {
                $adj_amount -= $adjustment->amount;
            }
            // DB::table('adjustments')->where('id', $adjustment->id)->update(['status' => 2]);
        }

        // calculate TAX
        $tax = DB::table('tax_histories')->select('*')
            ->where('employee_id', $employee->id)
            ->where('status', 'payed')
            // ->where('status', 'due')
            ->first();
        if (isset($tax)) {
            $tax_amount = $tax->amount;
            DB::table('tax_histories')->where('id', $tax->id)->update(['status' => 'payed']);
        }

        // check if hold
        $is_hold = DB::table('salary_hold_lists')
            ->where('employee_id', $employee->id)
            ->whereYear('month', '=', date('Y'))
            ->whereMonth('month', '=', date('m'))->first();


        $payable_salary = $gross_salary - $loan_amount - $pf_amount - $tax_amount - $lwp_amount + $adj_amount;
        $values = array(
            'employee_id' => $employee->id,
            'month' => date('Y-m-d'),
            'gross_salary' => $payable_salary,
            'is_hold' => $is_hold ? 1 : 0,
            'created_by' => Auth::user()->employee_id,
            'updated_by' => Auth::user()->employee_id,
        );
        DB::table('salary_history')->insert($values);
    }


    public function salaryHistory(Request $request)
    {

        $active = 'salary-history';
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');
        $employmentTypes = EmploymentType::all();
        $employeeStatus = EmployeeStatus::all();
        $divisions = Division::with('centers')->get();
        $centers = ($request->has('division_id') && $request->has('center_id')) ? Center::where('division_id', $request->get('division_id'))->get() : [];
        $departments = Department::all();
        $processes = Process::all();

        if(!$request->has('division_id') && !$request->has('center_id')){
            $salary_history = [];
            return view('admin.payroll.manageSalary.history', compact(
                'active',
                'salary_history',
                'employmentTypes',
                'employeeStatus',
                'divisions',
                'centers',
                'month',
                'year',
                'departments',
                'processes'
            ));
        }

        if($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT){
            $start_date = Carbon::createFromDate($year, $month - 1, 26)->toDateString();
            $end_date = Carbon::createFromDate($year, $month, 25)->toDateString();
        } else {
            $start_date = Carbon::createFromDate($year, $month - 1, 16)->toDateString();
            $end_date = Carbon::createFromDate($year, $month, 15)->toDateString();
        }

        $active_employee = Employee::select(['id', 'employer_id', 'gender'])
            ->divisionCenter($request->input('division_id'), $request->input('center_id'))
            ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
                return  $q->where('employment_type_id', $request->input('employment_type_id'))
                        ->where('employee_status_id', 1);
            })
            ->withoutGlobalScopes()
            ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();

        $closed_employees = Employee::select(['id', 'employer_id', 'gender'])
            ->divisionCenter($request->input('division_id'), $request->input('center_id'))
            ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
                return  $q->where('employment_type_id', $request->input('employment_type_id'))
                        ->where('employee_status_id', 2)
                        ->whereBetween('lwd', [$start_date,$end_date]);
            })
            ->withoutGlobalScopes()
            ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();
        $employees = $active_employee->merge($closed_employees);
        $employee_list  =   $employees->pluck('id')->toArray();

        $salary_history = salaryHistory::where('month', '=', Carbon::createFromDate($year, $month)->format('Y-m'))
            ->withoutGlobalScopes()
            ->whereHas('employee', function($q){
                $q->withoutGlobalScopes();
            })
            ->whereIn('employee_id', $employee_list)
            ->with(['employee' => function($q){
                $q->withoutGlobalScopes();
            }])
            ->when($request->get('employee_id'),function($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->withoutGlobalScopes()->select(['id', 'employer_id', 'first_name', 'last_name', 'gender'])->where('id', $request->get('employee_id'));
                });
            })
            ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.individualSalary', 'employee.individualSalary.paymentType', 'employee.individualSalary.incrementSalaryActive']);

        if (!empty($request->get('csv'))) {
            $salary_history =  $salary_history->get();
            $exportCSVdata = [];
            foreach($salary_history as $salary){
                $salary_account_type = '';
                $payment_type = '';
                if (isset($salary->employee->individualSalary->bank_account_type)) {
                    if ($salary->employee->individualSalary->bank_account_type == 1) {
                        $salary_account_type = 'Payroll/Prepaid';
                    } elseif ($salary->employee->individualSalary->bank_account_type == 2) {
                        $salary_account_type = 'Account';
                    }
                }
                if($salary->employee == null){
                    $salary->employee = Employee::withoutGlobalScopes()->find($salary->employee_id);
                }
                if (isset($salary->employee->individualSalary->type)) {
                    $salary_data = SalaryHistory::withoutGlobalScopes()->find($salary->id);
                    if($salary_data){
                        $payslip_data       =   json_decode($salary_data->payslip);
                        $allowance_data     =   $payslip_data ? json_decode($payslip_data->allowance_data) : [];
                        $adjustment_data    =   $payslip_data ? json_decode($payslip_data->adjustment_data) : [];
                        $salaryBreakdown    =   $payslip_data ? json_decode($payslip_data->breakdown) : [];
                        $employee           =   $payslip_data ? Employee::find($payslip_data->employee_id) : null;
                        $bankInfo           =   array(
                            'name'=> $salary_data->employee->individualSalary->bankInfo->bank_name ?? '',
                            'account' => $salary_data->employee->individualSalary->bank_account ?? ''
                        );

                        $other_allowance    =   0;
                        if(sizeof($allowance_data)) {
                            if(json_decode($allowance_data->allowance_addition) || json_decode($allowance_data->allowance_deduction)){
                                foreach(json_decode($allowance_data->allowance_addition) as $key => $addition){
                                    $other_allowance += $addition;
                                }
                                foreach(json_decode($allowance_data->allowance_deduction) as $key => $deduction){
                                    $other_allowance -= $deduction;
                                }
                            }
                        }

                        $adjustments        =   0;
                        $mobile_bill        =   0;
                        if(sizeof($allowance_data)) {
                            if(json_decode($adjustment_data->adjustment_addition) || json_decode($adjustment_data->adjustment_deduction)){
                                foreach(json_decode($adjustment_data->adjustment_addition) as $key => $addition){
                                    $adjustments += $addition;
                                }
                                foreach(json_decode($adjustment_data->adjustment_deduction) as $key => $deduction){
                                    if ($salary->employee->individualSalary->type == 0) {
                                        $adjustments -= $deduction;
                                    } else {
                                        if($key == 'Mobile Bill Deduction'){
                                            $mobile_bill = $deduction;
                                        } else {
                                            $adjustments -= $deduction;
                                        }
                                    }
                                }
                            }
                        }

                        $center         =   '';
                        $division       =   '';
                        $department     =   '';
                        $process        =   '';
                        $lob            =   '';
                        if($salary->employee->divisionCenters){
                            foreach($salary->employee->divisionCenters as $item){
                                $division   =   $item->division->name ?? null;
                                $center     =   $item->center->center ?? null;
                                break;
                            }
                        }
                        if($salary->employee->departmentProcess){
                            foreach($salary->employee->departmentProcess->unique('department_id') as $item){
                                $department =   $item->department->name ?? null;
                                break;
                            }
                        }
                        if($salary->employee->departmentProcess){
                            foreach($salary->employee->departmentProcess->unique('process_id') as $item){
                                $process    =   $item->process->name ?? null;
                                $lob        =   $item->processSegment->name ?? null;
                                break;
                            }
                        }

                        $kpi =   DB::table('individual_salaries')->where('employee_id', $salary->employee->id)->first();

                    } else {
                        // return true;
                    }

                    if ($salary->employee->individualSalary->type == 0) {
                        // hourly
                        $temp_val = array(
                            'Employee ID'           => $salary->employee->employer_id,
                            'Name'                  => $salary->employee->FullName,
                            'Month'                 => $payslip_data->month ?? '',
                            'Pay Cycle'             => $salary->employee->individualSalary->payCycle->name,
                            'Center'                => $center,
                            'Division'              => $division,
                            'Department'            => $department,
                            'Process'               => $process,
                            'LOB'                   => $lob,
                            'Rate 1'                => $salary->gross_salary,
                            'Rate 2'                => $kpi->kpi_rate ? $kpi->kpi_rate : '0.00' ,
                            'KPI Amount'            => $salaryBreakdown->kpi_bonus ? $salaryBreakdown->kpi_bonus : '0.00',
                            'KPI Grade'             => $salaryBreakdown->kpi_grade ? $salaryBreakdown->kpi_grade : '-',
                            'Login Hour'            => $salaryBreakdown->ready_hour ? $salaryBreakdown->ready_hour: "0:00",
                            'Lag Hour'              => $salaryBreakdown->lag_hour ? $salaryBreakdown->lag_hour : "0:00",
                            'Break Hour'            => $salaryBreakdown->break_hour ? $salaryBreakdown->break_hour : "0:00",
                            'OT Hour'               => $salaryBreakdown->ot_hour ? $salaryBreakdown->ot_hour : "0:00",
                            'Total Hour'            => isset($salaryBreakdown->total_hour) ? $salaryBreakdown->total_hour : "0:00",
                            'Adjustments(+/-)'      => $adjustments,
                            'Salary Type'           => 'Hourly',
                            'Payment Type'          => $salary->employee->individualSalary->paymentType->type,
                            'Employment Status'     => $salary->employee->employeeJourney ? $salary->employee->employeeJourney->employeeStatus->status : '',
                            'Payable Amount'        => $payslip_data->payable_salary ? number_format($payslip_data->payable_salary, 2) : '',
                            'Created by'            => ($salary->createdBy) ? $salary->createdBy->FullName : '',
                            'Created at'            => $salary->created_at
                        );
                        array_push($exportCSVdata, $temp_val);
                    } elseif ($salary->employee->individualSalary->type == 1) {
                        // fixed
                        $temp_val = array(
                            'Employee ID'           => $salary->employee->employer_id,
                            'Name'                  => $salary->employee->FullName,
                            'Month'                 => $payslip_data->month ?? '',
                            'Pay Cycle'             => $salary->employee->individualSalary->payCycle->name,
                            'Center'                => $center,
                            'Division'              => $division,
                            'Department'            => $department,
                            'Process'               => $process,
                            'LOB'                   => $lob,
                            'Rate 1'                => $salary->gross_salary,
                            'Rate 2'                => $kpi->kpi_rate ?? '0.00',
                            'Rate 3'                => $other_allowance,
                            'Overtime Days'         => $salaryBreakdown->holiday_present ?? '0.00',
                            'Overtime Amount'       => $salaryBreakdown ? number_format($salaryBreakdown->holiday_present * ($salaryBreakdown->perday_salary), 2) : 0.00,
                            'Final Payable Days'    => $salaryBreakdown ? $salaryBreakdown->present : '0.00',
                            'Payable Amount'        => $salaryBreakdown ? number_format($salaryBreakdown->present * $salaryBreakdown->perday_salary, 2) : 0.00,
                            'Allowance'             => $other_allowance,
                            'KPI Amount'            => $salaryBreakdown ? $salaryBreakdown->kpi_bonus : '0.00',
                            'KPI Grade'             => $salaryBreakdown ? $salaryBreakdown->kpi_grade : '-',
                            'Adjustments(+/-)'      => $adjustments,
                            'Mobile Bill'           => $mobile_bill,
                            'Salary Type'           => 'Fixed',
                            'Payment Type'          => $salary->employee->individualSalary->paymentType->type,
                            // 'Bank'                  => $salary->employee->individualSalary->bankInfo->bank_name,
                            // 'Branch'                => $salary->employee->individualSalary->bankBranch->bank_branch_name,
                            // 'Account'               => $salary->employee->individualSalary->bank_account,
                            'Account Type'          => $salary_account_type,
                            'Status'                => $salary->is_hold == 1 ? 'Hold' : 'Paid',
                            'Employment Status'     => $salary ? $salary->employee->employeeJourney->employeeStatus->status  : '-',
                            'Payable Amount (Fixed)'=> $payslip_data ? number_format($payslip_data->payable_salary, 2) : '0.00',
                            'Created by'            => ($salary->createdBy) ? $salary->createdBy->FullName : '',
                            'Created at'            => $salary->created_at
                        );
                        array_push($exportCSVdata, $temp_val);
                    }
                }
            }
            return (new FastExcel($exportCSVdata))->download('Salary History.csv');
        } else {
            $salary_history = $salary_history->paginate(10);
        }

        return view('admin.payroll.manageSalary.history', compact(
            'active',
            'salary_history',
            'employmentTypes',
            'employeeStatus',
            'divisions',
            'centers',
            'month',
            'year',
            'processes',
            'departments'
        ));
    }



    public function salaryHistory_old(Request $request)
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
        $departments = Department::all();
        $processes = Process::all();
        if(!$request->has('division_id') && !$request->has('center_id')){
            $salary_history = [];
            return view('admin.payroll.manageSalary.history', compact(
                'active',
                'salary_history',
                'employmentTypes',
                'employeeStatus',
                'divisions',
                'centers',
                'month',
                'year',
                'departments',
                'processes'
            ));
        }

        $salary_history = salaryHistory::withoutGlobalScopes()->where('month', $year.'-'.$month)
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
            ->when($request->get('department_id'),function($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->whereHas('departmentProcess', function ($q) use ($request){
                        $q->where('department_id', $request->get('department_id'));
                    });
                });
            })
            ->when($request->get('process_id'),function($q) use ($request){
                $q->whereHas('employee', function ($q) use ($request){
                    $q->whereHas('departmentProcess', function ($q) use ($request){
                        $q->where('process_id', $request->get('process_id'));
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
            ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.employeeJourney.employeeStatus', 'salaryDetails', 'salaryGeneratedBreakdowns']);

        // if($request->input('employment_type_id') == EmploymentTypeStatus::PERMANENT){
        //     $start_date = Carbon::createFromDate($year, $month - 1, 26)->toDateString();
        //     $end_date = Carbon::createFromDate($year, $month, 25)->toDateString();
        // } else {
        //     $start_date = Carbon::createFromDate($year, $month - 1, 16)->toDateString();
        //     $end_date = Carbon::createFromDate($year, $month, 15)->toDateString();
        // }

        // $active_employee = Employee::select(['id', 'employer_id', 'gender'])
        //     ->divisionCenter($request->input('division_id'), $request->input('center_id'))
        //     ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
        //         return  $q->where('employment_type_id', $request->input('employment_type_id'))
        //                 ->where('employee_status_id', 1);
        //     })
        //     ->withoutGlobalScopes()
        //     ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();

        // $closed_employees = Employee::select(['id', 'employer_id', 'gender'])
        //     ->divisionCenter($request->input('division_id'), $request->input('center_id'))
        //     ->whereHas('employeeJourney', function($q) use ($request, $start_date, $end_date){
        //         return  $q->where('employment_type_id', $request->input('employment_type_id'))
        //                 ->where('employee_status_id', 2)
        //                 ->whereBetween('lwd', [$start_date,$end_date]);
        //     })
        //     ->withoutGlobalScopes()
        //     ->with(['employeeJourney', 'employeeJourney.employmentType'])->get();

        // // dd($closed_employees);
        // // dd($active_employee);
        // $employees = $active_employee->merge($closed_employees);
        // // dd($employees);
        // $employee_list  =   $employees->pluck('id')->toArray();
        // $employees      =   $employees->get();

        // dd($employee_list);


        // getting salary history count
        // $salary_history = salaryHistory::whereYear('month', '=', $year)
        //     ->whereMonth('month', '=', $month)
        //     ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.individualSalary', 'employee.individualSalary.paymentType', 'employee.individualSalary.incrementSalaryActive']);

        // $salary_history = salaryHistory::where('month', '=', Carbon::createFromDate($year, $month)->format('Y-m'))
        //     ->withoutGlobalScopes()
        //     ->whereIn('employee_id', $employee_list)
        //     ->with(['employee', 'employee.employeeJourney', 'employee.employeeJourney.employmentType', 'employee.individualSalary', 'employee.individualSalary.paymentType', 'employee.individualSalary.incrementSalaryActive']);

            // $salary_history =  $salary_history->get();
            // $salary_gen_for =  $salary_history->pluck('employee_id')->toArray();
            // $missing_ids = [];
            // // foreach($salary_history as $salary){
            // //     if(!in_array($salary->employee_id, $employee_list)){
            // //         array_push($missing_ids, $salary->employee_id);
            // //     }
            // //     // $salary_data = SalaryHistory::withoutGlobalScopes()->find($salary->id);
            // //     // echo "<pre>";
            // //     // print_r($salary_data);
            // // }
            // foreach($employee_list as $employee){
            //     if(!in_array($employee, $salary_gen_for)){
            //         array_push($missing_ids, $employee);
            //     }
            //     // $salary_data = SalaryHistory::withoutGlobalScopes()->find($salary->id);
            //     // echo "<pre>";
            //     // print_r($salary_data);
            // }
            // dd($salary_gen_for);
            // dd($missing_ids);
            // dd($salary_history->count());

            if (!empty($request->get('csv'))) {
                $salary_history =  $salary_history->get();
                // return (new FastExcel($salary_history))->download('Salary History.csv');
                return (new FastExcel($salary_history))->download('Salary History.csv', function ($salary) {
                    $salary_account_type = '';
                    $payment_type = '';
                    if (isset($salary->employee->individualSalary->bank_account_type)) {
                        if ($salary->employee->individualSalary->bank_account_type == 1) {
                            $salary_account_type = 'Payroll/Prepaid';
                        } elseif ($salary->employee->individualSalary->bank_account_type == 2) {
                            $salary_account_type = 'Account';
                        }
                    }
                    if (isset($salary->employee->individualSalary->type)) {

                        $salary_data = SalaryHistory::withoutGlobalScopes()->find($salary->id);
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

                            $other_allowance    =   0;
                            if(json_decode($allowance_data->allowance_addition) || json_decode($allowance_data->allowance_deduction)){
                                foreach(json_decode($allowance_data->allowance_addition) as $key => $addition){
                                    $other_allowance += $addition;
                                }
                                foreach(json_decode($allowance_data->allowance_deduction) as $key => $deduction){
                                    $other_allowance -= $deduction;
                                }
                            }

                            $adjustments        =   0;
                            $mobile_bill        =   0;
                            if(json_decode($adjustment_data->adjustment_addition) || json_decode($adjustment_data->adjustment_deduction)){
                                foreach(json_decode($adjustment_data->adjustment_addition) as $key => $addition){
                                    $adjustments += $addition;
                                }
                                foreach(json_decode($adjustment_data->adjustment_deduction) as $key => $deduction){
                                    if ($salary->employee->individualSalary->type == 0) {
                                        $adjustments -= $deduction;
                                    } else {
                                        if($key == 'Mobile Bill Deduction'){
                                            $mobile_bill = $deduction;
                                        } else {
                                            $adjustments -= $deduction;
                                        }
                                    }
                                }
                            }

                            $center         =   '';
                            $division       =   '';
                            $department     =   '';
                            $process        =   '';
                            $lob            =   '';
                            if($salary->employee->divisionCenters){
                                foreach($salary->employee->divisionCenters as $item){
                                    $division   =   $item->division->name ?? null;
                                    $center     =   $item->center->center ?? null;
                                    break;
                                }
                            }
                            if($salary->employee->departmentProcess){
                                foreach($salary->employee->departmentProcess->unique('department_id') as $item){
                                    $department =   $item->department->name ?? null;
                                    break;
                                }
                            }
                            if($salary->employee->departmentProcess){
                                foreach($salary->employee->departmentProcess->unique('process_id') as $item){
                                    $process    =   $item->process->name ?? null;
                                    $lob        =   $item->processSegment->name ?? null;
                                    break;
                                }
                            }

                            $kpi =   DB::table('individual_salaries')->where('employee_id', $salary->employee->id)->first();

                        } else {
                            // return true;
                        }

                        if ($salary->employee->individualSalary->type == 0) {
                            // hourly
                            // $hours =   DB::table('individual_salaries')->where('employee_id', $salary->employee->id)->first();
                            return [
                                'Employee ID'           => $salary->employee->employer_id,
                                'Name'                  => $salary->employee->FullName,
                                'Month'                 => $payslip_data->month ?? '',
                                'Pay Cycle'             => $salary->employee->individualSalary->payCycle->name,
                                'Center'                => $center,
                                'Division'              => $division,
                                'Department'            => $department,
                                'Process'               => $process,
                                'LOB'                   => $lob,
                                'Rate 1'                => $salary->gross_salary,
                                'Rate 2'                => $kpi->kpi_rate ? $kpi->kpi_rate : '0.00' ,
                                'KPI Amount'            => $salaryBreakdown->kpi_bonus ? $salaryBreakdown->kpi_bonus : '0.00',
                                'KPI Grade'             => $salaryBreakdown->kpi_grade ? $salaryBreakdown->kpi_grade : '-',
                                'Login Hour'            => $salaryBreakdown->ready_hour ? $salaryBreakdown->ready_hour: "0:00",
                                'Lag Hour'              => $salaryBreakdown->lag_hour ? $salaryBreakdown->lag_hour : "0:00",
                                'Break Hour'            => $salaryBreakdown->break_hour ? $salaryBreakdown->break_hour : "0:00",
                                'OT Hour'               => $salaryBreakdown->ot_hour ? $salaryBreakdown->ot_hour : "0:00",
                                'Total Hour'            => $salaryBreakdown->total_hour ? $salaryBreakdown->total_hour : "0:00",
                                'Adjustments(+/-)'      => $adjustments,
                                'Salary Type'           => 'Hourly',
                                'Payment Type'          => $salary->employee->individualSalary->paymentType->type,
                                'Employment Status'     => $salary->employee->employeeJourney ? $salary->employee->employeeJourney->employeeStatus->status : '',
                                'Payable Amount'        => $payslip_data->payable_salary ? number_format($payslip_data->payable_salary, 2) : '',
                                'Created by'            => ($salary->createdBy) ? $salary->createdBy->FullName : '',
                                'Created at'            => $salary->created_at
                            ];
                        } elseif ($salary->employee->individualSalary->type == 1) {
                            // fixed

                            // 'Start Date'            => $payslip_data->cycle_start ?? '',
                            // 'End Date'              => $payslip_data->cycle_end ?? '',

                            return [
                                'Employee ID'           => $salary->employee->employer_id,
                                'Name'                  => $salary->employee->FullName,
                                'Month'                 => $payslip_data->month ?? '',
                                'Pay Cycle'             => $salary->employee->individualSalary->payCycle->name,
                                'Center'                => $center,
                                'Division'              => $division,
                                'Department'            => $department,
                                'Process'               => $process,
                                'LOB'                   => $lob,
                                'Rate 1'                => $salary->gross_salary,
                                'Rate 2'                => $kpi->kpi_rate ?? '0.00',
                                'Rate 3'                => $other_allowance,
                                'Overtime Days'         => $salaryBreakdown->holiday_present ?? '0.00',
                                'Overtime Amount'       => number_format($salaryBreakdown->holiday_present * ($salaryBreakdown->perday_salary), 2) ?? 0.00,
                                'Final Payable Days'    => $salaryBreakdown->present ?? '0.00',
                                'Payable Amount'        => number_format($salaryBreakdown->present * $salaryBreakdown->perday_salary, 2) ?? 0.00,
                                'Allowance'             => $other_allowance,
                                'KPI Amount'            => $salaryBreakdown->kpi_bonus ?? '0.00',
                                'KPI Grade'             => $salaryBreakdown->kpi_grade ?? '-',
                                'Adjustments(+/-)'      => $adjustments,
                                'Mobile Bill'           => $mobile_bill,
                                'Salary Type'           => 'Fixed',
                                'Payment Type'          => $salary->employee->individualSalary->paymentType->type,
                                'Bank'                  => $salary->employee->individualSalary->bankInfo->bank_name,
                                'Branch'                => $salary->employee->individualSalary->bankBranch->bank_branch_name,
                                'Account'               => $salary->employee->individualSalary->bank_account,
                                'Account Type'          => $salary_account_type,
                                'Status'                => $salary->is_hold == 1 ? 'Hold' : 'Paid',
                                'Employment Status'     => $salary->employee->employeeJourney->employeeStatus->status  ?? '',
                                'Payable Amount (Fixed)'=> number_format($payslip_data->payable_salary, 2) ?? '',
                                'Created by'            => ($salary->createdBy) ? $salary->createdBy->FullName : '',
                                'Created at'            => $salary->created_at
                            ];
                        }
                    }
                });
            } else {
                $salary_history = $salary_history->paginate(10);
            }

//        if (isset($request->date)) {
//            $y = date_format(date_create($request->date), "Y");
//            $m = date_format(date_create($request->date), "m");
//            $salary_history = SalarySummaryHistory::whereYear('month', '=', $y)
//                ->whereMonth('month', '=', $m)->get();
//        } else {
//            $salary_history = SalarySummaryHistory::all();
//        }
        return view('admin.payroll.manageSalary.history', compact(
            'active',
            'salary_history',
            'employmentTypes',
            'employeeStatus',
            'divisions',
            'centers',
            'month',
            'year',
            'departments',
            'processes'
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
    // public function salaryHistory(Request $request){
    //     $active = 'salary-history';
    //     $emoloyees = Employee::all();
    //     $salary_history = SalarySummaryHistory::all();
    //     return view('admin.payroll.manageSalary.history', compact('active', 'salary_history'));
    // }
    public function salaryValidationCheck(Request $request)
    {
        $type = $request->type;
        return $type;
    }

    public function addEmployeeHours(Request $request)
    {
        $active = 'manage-employee-hours';
        return view('admin.payroll.employeeHours.add', compact('active'));
    }

    public function editEmployeeHours(Request $request, $id)
    {
        $active = 'manage-employee-hours';
        $hour_info = EmployeeHours::find($id);
        // dd($id);
        return view('admin.payroll.employeeHours.add', compact('active', 'hour_info'));
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
        $active     =   'manage-employee-hours';
        $departments = Department::all();
        $processes = Process::all();
        $query      =   EmployeeHours::query()->with('employee');
        $startDate  =   $request->start_date;
        $endDate    =   $request->end_date;
        $paginate   =   10;
        $hour_type  =   array(
            '0' => 'Regular',
            '1' => 'Adjusted',
            '2' => 'Overtime'
        );
        $requestCheck   =   $request->all();
        if (!$requestCheck) {
            $salary_history =   $query->paginate($paginate);
            return view('admin.payroll.employeeHours.history', compact('active', 'salary_history', 'hour_type', 'startDate', 'endDate', 'departments', 'processes'));
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

        $salary_history     =   $query->paginate($paginate);
        return view('admin.payroll.employeeHours.history', compact('active', 'salary_history', 'hour_type', 'startDate', 'endDate', 'departments', 'processes'));
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
        return view('admin.payroll.employeeHours.upload', compact('active'));
    }



    public function employeeHoursClearanceView($startDate, $endDate)
    {
        $active = 'manage-employee-hours-view';
        return view('admin.payroll.employeeHours.clearance', compact('active', 'startDate', 'endDate'));
    }

    // public function importEmployeeHourCsv_old(Request $request){

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

    public function importEmployeeHourCsv(Request $request)
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

        //Excel::import(new EmployeeHourImport($employee_id), $request->file('excel_file'));

        (new EmployeeHourImport(request()->user()->employee_id))->queue($request->file('excel_file'))->chain([
            new NotifyUserOfCompletedEmployeeHourImport(request()->user()),
        ]);

        toastr()->warning('Your data push in the queue. After data upload compilation let you notify!');

        return redirect()->route('manage.salary.employee.hours');
    }

    /* Start Employee Attendance Upload */
    public function addEmployeeAttendances(Request $request)
    {
        $active = 'manage-employee-attendance';
        return view('admin.payroll.employeeAttendances.add', compact('active'));
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
        return view('admin.payroll.employeeAttendances.edit', compact('active', 'hour_info', 'id'));
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

    public function employeeAttendances(Request $request)
    {
        $active     =   'manage-employee-attendance';
        $query      =   EmployeeAttendance::query()->with('employee');
        $startDate  =   $request->start_date;
        $endDate    =   $request->end_date;
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
            return view('admin.payroll.employeeAttendances.history', compact('active', 'salary_history', 'attendance_type', 'startDate', 'endDate'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history =   $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            $employee   =   Employee::where('employer_id', $request->employee_id)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            }
        }
        if ($request->attendance_type) {
            $query->where('status', $request->attendance_type);
        }
        $salary_history     =   $query->paginate($paginate);
        return view('admin.payroll.employeeAttendances.history', compact('active', 'salary_history', 'attendance_type', 'startDate', 'endDate'));
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
        return view('admin.payroll.employeeAttendances.upload', compact('active'));
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

    public function employeeAttendancesClearanceView($startDate, $endDate)
    {
        $active = 'manage-employee-attendance-view';
        return view('admin.payroll.employeeAttendances.clearance', compact('active', 'startDate', 'endDate'));
    }

    public function employeeAttendanceClearanceUpdate(Request $request)
    {
        dd('test');
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

        // $new_file_name = md5(uniqid()) . '.' . $request->file('excel_file')->getClientOriginalExtension();
        // $destinationPath = storage_path('app/import-temp/');
        // $path = $request->file('excel_file')->move($destinationPath, $new_file_name);

        // Excel::import(new EmployeeAttendanceImport($request), $path);
        // unlink($destinationPath.$new_file_name);
        (new EmployeeAttendanceImport(request()->user()->employee_id))->queue($request->file('excel_file'))->chain([
            new NotifyUserOfCompletedEmployeeAttendanceImport(request()->user()),
        ]);

        toastr()->warning('Your data push in the queue. After data upload compilation let you notify!');
        return redirect()->route('manage.salary.employee.attendance');
    }



    public function importEmployeeAttendanceCsv_old(Request $request)
    {

        set_time_limit(300);

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
    /* End Employee Attendance Upload */


    // salary settings
    public function salarySettings()
    {
        $active = 'salary-settings';
        $salaryBreakdownSettings = SalaryBreakdownSetting::all();
        return view('admin.payroll.manageSalary.settings', compact('active', 'salaryBreakdownSettings'));
    }

    public function salarySettingsSubmit(Request $request)
    {
        DB::table('salary_breakdown_settings')->delete();
        foreach ($request->get('salary_breakdown') as $key => $item) {
            $salaryBreakdownSettings = new SalaryBreakdownSetting();
            $salaryBreakdownSettings->create([
                'name' => $item['name'],
                'percentage' => $item['percentage'],
                'is_basic' => ($key == 0) ? 1 : 0
            ]);
        }
        return redirect()->back();
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

        if($type == EmploymentTypeStatus::HOURLY || $type ==  EmploymentTypeStatus::PROJECTBASEHOURLY){
            $pageName = 'pay-slip-view-hourly';
            // $salaryBreakdown = $this->preparedPaySlipDataForHourly($id);
        }

        if($type == EmploymentTypeStatus::CONTRACTUAL || $type ==  EmploymentTypeStatus::PROJECTBASEFIXED){
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
            'employer_id' => $salary->employee->employer_id ?? '',
            'name' => $salary->employee->FullName ?? '',
            'start_date' => Carbon::parse($salary->start_date)->format('d M, Y') ?? '',
            'end_date' => Carbon::parse($salary->end_date)->format('d M, Y') ?? '',
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
                //$salaryBreakdown['adjustment']['add'][array_search($data->salary_details_type, $payrollSalaryDetail)] = $data->amount ?? 0;
            }else{
                $gndAmount -= $data->amount ?? 0;
                $salaryBreakdown['adjustment']['deduct'][array_search($data->salary_details_type, $payrollSalaryDetail)] = $data->amount ?? 0;
            }
        }
        // add brackdown adjustment
        $salaryBreakdown['adjustment']['add'] =  Adjustment::select('*')
            ->where('employee_id', $employeeId)
            ->where('month', $yearMonth)
            ->where('type', 'addition')
            ->get();

        // dd($salaryBreakdown['adjustment']['add']);

        // dd($salaryBreakdown);

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
        $salaryBreakdown['adjustment']['other_allowances']['OTHERS ALLOWANCES'] = $allowance;
        // dd($allowance);


        // calculate KPI
        $kpi_bonus = 0;
        $kpi = DB::table('kpis')->where('employee_id', $employeeId)->where('monthly_date', $yearMonth)->get();
        // dd($kpi);
        if (isset($kpi->amount)) {
            $kpi_bonus = $kpi->amount;
        }
        $salaryBreakdown['kpis'] = $kpi;


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



    public function releasePreviousHold($month, $year)
    {
        $active = '';
        $salaryHistory = SalaryHistory::with('employee')->where('is_hold', 1)->where('month', '=', $year.'-'.$month)->get();
        // dd($salaryHistory);
        return view('admin.payroll.manageSalary.release-previous-hold', compact('active','salaryHistory', 'year', 'month'));
    }

    public function salaryHoldRelease($id)
    {
        $adjustmentType = AdjustmentType::all();
        $salary = SalaryHistory::find($id);

        $yearMonth = explode('-', $salary->month);
        $salaryHoldData = [];

        if(!empty($yearMonth)){
            $year = $yearMonth[0];
            $month = $yearMonth[1];
            $employeeId = $salary->employee_id;
            $salaryHold = SalaryHoldList::where('employee_id', $employeeId)
                ->whereYear('month', $year)
                ->whereMonth('month', $month)
                ->first();

            $salaryHoldData['resoan'] = array_search($salaryHold->hold_reason, Payroll::SALARYHOLDREASON);
            $salaryHoldData['remarks'] = $salaryHold->remarks;
        }

        return view('admin.payroll.manageSalary.edit', compact('salary','adjustmentType', 'salaryHoldData', 'id'));
    }

    public function salaryHoldReleaseUpdate(Request $request,$id)
    {
        $salary = SalaryHistory::findOrFail($id);

        $salaryHistory = [
            'is_hold' => 0,
            'release_by' => Auth()->user()->employee_id ?? 16,
            'release_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'release_remarks' => $request->remarks ?? ''
        ];
        SalaryHistory::findOrFail($id)->update($salaryHistory);

        /* $salaryDetails = [
            'employee_id' => $salary->employee_id,
            'salary_history_id' => $id,
            'salary_details_type' => Payroll::SALARYDETAILS['RELEASED'],
            'amount' => $request->amount,
            'add_or_deduct' => ($request->type == 'addition') ? 1 : 2,
        ];
        SalaryDetail::create($salaryDetails); */


        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0|not_in:0'
        ]);

        if (!$validator->fails()) {
             $adjustment = [
                'employee_id' => $salary->employee_id,
                'adjustment_type' => $request->adjustment_type,
                'type' => $request->type,
                'amount' => $request->amount,
                'status' => Payroll::ADJUSTMENT['status']['Payed'],
                'adjustment_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                'month' => $salary->month,
                'remarks' => $request->remarks ?? '',
                'created_by' => Auth()->user()->employee_id ?? 16,
                'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                'updated_by' => Auth()->user()->employee_id ?? 16,
                'updated_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            ];
            Adjustment::create($adjustment);
        }



        $salaryHoldList = [
            'employee_id' => $salary->employee_id,
            'status' => Payroll::SALARYHOLD['status']['Release'],
            'month' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'remarks' => $request->remarks ?? '',
            'release_by' => Auth()->user()->employee_id,
            'release_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
        ];
        $salaryHoldList = SalaryHoldList::where('employee_id', $salary->employee_id)
        ->whereYear('month',Carbon::parse($salary->month)->format('Y'))
        ->whereMonth('month',Carbon::parse($salary->month)->format('m'))->update($salaryHoldList);

        if(!$salaryHoldList){
            toastr()->warning('Not Found Salary Hold Data!');
        }
        toastr()->success('Successfully Updated!');
        return redirect()->back();

    }

    // Employee attendance summary starts

    public function addEmployeeAttendanceSummary(Request $request)
    {
        $active = 'manage-employee-attendance-summary';
        return view('admin.payroll.employeeAttendanceSummary.add', compact('active'));
    }

    public function editEmployeeAttendanceSummary(Request $request, $id)
    {
        $active = 'manage-employee-attendance-summary';
        $attendance_info = EmployeeAttendanceSummary::find($id);
        // dd($id);
        return view('admin.payroll.employeeAttendanceSummary.add', compact('active', 'attendance_info'));
    }

    public function updateEmployeeAttendanceSummary(Request $request)
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
                'employee_id' => $request->hour_type,
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

    public function employeeAttendanceSummary(Request $request)
    {
        $active = 'manage-employee-attendance-summary';
        $query = EmployeeAttendanceSummary::query();
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
            $attendance_summary_history = $query->paginate($paginate);
            return view('admin.payroll.employeeAttendanceSummary.history', compact('active', 'attendance_summary_history', 'hour_type', 'startDate', 'endDate'));
        }
        if ($startDate) {
            $attendance_summary_history = $query->where('month', $startDate);
        }
        if ($request->employee_id) {
            $employee = Employee::where('employer_id', $request->employee_id)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            }
        }
        if ($request->type) {
            $query->where('hour_type', $request->type);
        }
        $attendance_summary_history = $query->paginate($paginate);
        return view('admin.payroll.employeeAttendanceSummary.history', compact('active', 'attendance_summary_history', 'hour_type', 'startDate', 'endDate'));
    }

    public function employeeAttendanceSummaryClearanceUpdate(Request $request)
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

    public function employeeAttendanceSummaryUploadView(Request $request)
    {
        $active = 'manage-employee-attendance-summary-view';
        return view('admin.payroll.employeeAttendanceSummary.upload', compact('active'));
    }

    public function employeeAttendanceSummaryClearanceView($startDate, $endDate)
    {
        $active = 'manage-employee-attendance-summary-view';
        return view('admin.payroll.employeeAttendanceSummary.clearance', compact('active', 'startDate', 'endDate'));
    }

    public function importEmployeeAttendanceSummaryCsv(Request $request)
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

       $attendanceData = $this->csvToArray($file);
       $data = [];
    //    dd($attendanceData);
       foreach ($attendanceData as $att_data) {
           $employee = Employee::where('employer_id', $att_data['Employee ID'])->first();
           $unknownEmployerId = [];

           if ($employee) {
               $row_data = array(
                    'month' => $att_data['Month'],
                    'employee_id' => $employee->id,
                    'present' => $att_data['Present'],
                    'holiday' => $att_data['Holiday'],
                    'holiday_present' => $att_data['Holiday Present'],
                    'half_day' => $att_data['Halfday'],
                    'half_day_present' => $att_data['Halfday Present'],
                    'weekoff' => $att_data['Weekoff'],
                    'adj_day_off' => $att_data['Adj. Dayoff'],
                    'absent' => $att_data['Absent'],
                    'lwp' => $att_data['LWP'],
                    'created_at' => date('Y-m-d h:i:s'),
                    'created_by' => auth()->user()->id,
               );
               array_push($data, $row_data);

           } else {
               $unknownEmployerId[] = $att_data['Employee ID'];
           }
       }

        // dd($unknownEmployerId);
        //    return ($data);
        if ($data) {
            EmployeeAttendanceSummary::where('month', $att_data['Month'])->delete();
            EmployeeAttendanceSummary::insert($data);
            // DB::transaction(function () use ($data) {
            //    DB::table('employee_attendance_summary')->insert($data);
            // });
        }
        foreach ($unknownEmployerId  as $item) {
           toastr()->error('Unknown employer ID ' . $item . '. Data is not inserted for this unknown ID');
        }
        toastr()->success('Successfully Uploaded !');
        return redirect()->route('manage.salary.employee.attendance-summary');
    }

}
