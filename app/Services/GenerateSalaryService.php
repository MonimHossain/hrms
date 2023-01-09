<?php

namespace App\Services;

use App\Adjustment;
use App\Employee;
use App\IndividualOtherAllowance;
use App\Leave;
use App\ProvidentHistory;
use App\SalaryDetail;
use App\SalaryGeneratedBreakdown;
use App\salaryHistory;
use App\SalaryHoldList;
use App\TaxHistory;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\Payroll;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class GenerateSalaryService
{
    private $request, $month, $year, $start_date, $end_date;

    public function __construct($request)
    {
        $this->request = $request;
        $this->month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $this->year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');

        $this->start_date = Carbon::createFromDate($this->year, $this->month - 1, 26)->toDateString();
        $this->end_date = Carbon::createFromDate($this->year, $this->month, 25)->toDateString();
    }

    // generate permanent salary
    public function generatePermanentSalary()
    {

        $request = $this->request;
        $start_date = $this->start_date;
        $end_date = $this->end_date;
        // dd($request);
        $employee_list = Employee::select(['id', 'employer_id', 'first_name', 'last_name'])
            ->divisionCenter($request->input('division_id'), $request->input('center_id'))
            ->whereHas('employeeJourney', function ($q) use($request) {
                $q->where('employment_type_id', $request->input('employment_type_id'));
            })
            ->whereHas('individualSalary', function ($q) {
                $q->where('type', 1)->where('salary_status', 1);
            })
            ->with(['individualSalary', 'individualSalary.individualSalaryBreakdowns', 'individualSalary.individualOtherAllowances', 'individualSalary.incrementSalaryActive' => function ($query) {
                $query->where('type', 1);
            }])
            ->get();

        // dd($employee_list);

        $employee_ids = $employee_list->map(function ($employee) {
            return collect($employee->toArray())
                ->only(['id'])
                ->all();
        });

        // provident fund
        $allPf = ProvidentHistory::whereIn('employee_id', $employee_ids)->where('month', date('Y-m', strtotime($request->year.'-'.$request->month)))
            ->where('status', Payroll::PF['Generated'])
            ->get();



        // leave without pay
        $allLwp = Leave::whereIn('employee_id', $employee_ids)
            ->where(function($query) use ($start_date, $end_date){
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date]);
            })
            ->where('leave_type_id', LeaveStatus::LWP)
            ->where('leave_status', LeaveStatus::APPROVED)
            ->get();

        // adjustments
        $allAdjustments = Adjustment::whereIn('employee_id', $employee_ids)
            ->where('status', Payroll::ADJUSTMENT['status']['Generated'])
            ->get();
        
        // other fixed adjustments
        $allOtherAllowances = IndividualOtherAllowance::whereIn('employee_id', $employee_ids)
            ->get();

        // TAX
        $allTax = TaxHistory::whereIn('employee_id', $employee_ids)
            ->where('status', Payroll::TAX['Generated'])
            ->where('month', date('Y-m', strtotime($request->year.'-'.$request->month)))
            ->get();


        // salary hold list
        $allHold = SalaryHoldList::whereYear('month', '=', date('Y', strtotime($request->year)))
            ->whereMonth('month', '=', date('m', strtotime($request->month)))
            ->where('status', Payroll::SALARYHOLD['status']['Hold'])
            ->get();


        // dd($request->all());


        $salaries = [];
        foreach ($employee_list as $employee) {

            $pfs = $allPf->filter(function ($pf, $key) use ($employee) {
                return $pf->employee_id == $employee->id;
            });

            $lwp = $allLwp->filter(function ($leave, $key) use ($employee) {
                return $leave->employee_id == $employee->id;
            });
            $lwpQuantity = $lwp->sum('quantity');

            $taxes = $allTax->filter(function ($tax, $key) use ($employee) {
                return $tax->employee_id == $employee->id;
            });

            $adjustments = $allAdjustments->filter(function ($adjustment, $key) use ($employee) {
                return $adjustment->employee_id == $employee->id;
            });
            
            $allownces = $allOtherAllowances->filter(function ($adjustment, $key) use ($employee) {
                return $adjustment->employee_id == $employee->id;
            });
            
            $adjustments = $allAdjustments->filter(function ($adjustment, $key) use ($employee) {
                return $adjustment->employee_id == $employee->id;
            });

            $is_hold = $allHold->filter(function ($hold, $key) use ($employee) {
                return $hold->employee_id == $employee->id;
            })->first();
            // dd('dasd');
            // calculate permanent salary
            $salaries[] = $this->calculatePermanentSalary($employee, $pfs, $taxes, $lwpQuantity, $adjustments, $is_hold, $allownces);
            // $salaries = $this->calculatePermanentSalary($employee, $pfs, $taxes, $lwpQuantity, $adjustments, $is_hold);
        }

        // dd($salaries);

        // try {
        //     DB::transaction(function () use ($salaries) {
        //         DB::table('salary_history')->insert($salaries);
        //     });
        // } catch (\Exception $e) {
        //     return $e;
        // }

        // return true;
        return $salaries;
    }

    public function calculatePermanentSalary($employee, $pfs, $taxes, $lwpQuantity, $adjustments, $is_hold, $allownces)
    {
        $individualSalary = $employee->individualSalary->getIndividualSalaryWithIncrement();
        $gross_salary   =   $individualSalary->gross_salary;
        $loan_amount    =   0;
        $pf_amount      =   0;
        $tax_amount     =   0;
        $adj_amount     =   0;
        $lwp_amount     =   0;
        $otherAllowance =   0;

        $request = $this->request;

        if($request->has('is_deductable') && $request->input('is_deductable') == 1){
            // calculate lwp
            if ($lwpQuantity) {
                $total_days = Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date))+1;
                $perday_salary = $gross_salary / $total_days;
                $lwp_amount = $lwpQuantity * $perday_salary;
            }

            // calculate allowance
            foreach ($allownces as $allowance) {
                if ($allowance->type == 'addition') {
                    $otherAllowance += $allowance->amount;
                } else {
                    $otherAllowance -= $allowance->amount;
                }
            }
            
            // calculate adjustments
            $adjustment_ids = [];
            foreach ($adjustments as $adjustment) {
                if ($adjustment->type == 'addition') {
                    $adj_amount += $adjustment->amount;
                } else {
                    $adj_amount -= $adjustment->amount;
                }
                $adjustment_ids[] = $adjustment->id;
            }
            if (count($adjustment_ids)) {
                DB::table('adjustments')->whereIn('id', $adjustment_ids)->update(['status' => Payroll::ADJUSTMENT['status']['Due']]);
            }

            // calculate TAX
            $tax_ids = [];
            foreach ($taxes as $tax) {
                $tax_amount += $tax->amount;
                $tax_ids[] = $tax->id;
            }
            if (count($tax_ids)) {
                DB::table('tax_histories')->whereIn('id', $tax_ids)->update(['status' => Payroll::TAX['Due']]);
            }

            // calculate PF
            $pf_ids = [];
            foreach ($pfs as $pf) {
                $pf_amount += $pf->amount;
                $pf_ids[] = $pf->id;
            }
            if (count($pf_ids)) {
                DB::table('provident_histories')->whereIn('id', $pf_ids)->update(['status' => Payroll::PF['Due']]);
            }
        }

        $payable_salary = $gross_salary - $loan_amount - $pf_amount - $tax_amount - $lwp_amount + $adj_amount + $otherAllowance;
        // dd($payable_salary);
        // return array(
        //     'employee_id' => $employee->id,
        //     'month' => date('Y-m-d'),
        //     'gross_salary' => $payable_salary,
        //     'is_hold' => $is_hold ? 1 : 0,
        //     'created_by' => Auth::user()->employee_id,
        //     'updated_by' => Auth::user()->employee_id,
        // );


        DB::beginTransaction();

        try {
            
            // Delete previous salary data if this requested month for this current user
            salaryHistory::where('employee_id', $employee->id)->where('month', $this->year . '-' . $this->month)->delete();

            $salaryHistory = new salaryHistory();
            $salaryHistory->employee_id = $employee->id;
            $salaryHistory->employment_type_id = $employee->employeeJourney->employment_type_id;
            $salaryHistory->month = $this->year . '-' . $this->month;
            $salaryHistory->start_date = $this->start_date;
            $salaryHistory->end_date = $this->end_date;
            $salaryHistory->gross_salary = $gross_salary;
            $salaryHistory->payable_amount = $payable_salary;
            $salaryHistory->created_by = Auth::user()->employee_id;
            $salaryHistory->updated_by = Auth::user()->employee_id;
            // dd($salaryHistory);
            $salaryHistory->save();

            foreach(Payroll::SALARYDETAILS as $key => $details){
                $salaryDetails = new SalaryDetail();
                $salaryDetails->employee_id = $employee->id;
                $salaryDetails->salary_history_id = $salaryHistory->id;
                if($key == 'PF'){
                    $salaryDetails->salary_details_type = Payroll::SALARYDETAILS['PF'];
                    $salaryDetails->amount = $pf_amount;
                    $salaryDetails->add_or_deduct = 2; // deduct
                }elseif($key == 'TAX'){
                    $salaryDetails->salary_details_type = Payroll::SALARYDETAILS['TAX'];
                    $salaryDetails->amount = $tax_amount;
                    $salaryDetails->add_or_deduct = 2; // deduct
                } elseif ($key == 'ADJUSTMENT') {
                    $salaryDetails->salary_details_type = Payroll::SALARYDETAILS['ADJUSTMENT'];
                    $salaryDetails->amount = $adj_amount;
                    $salaryDetails->add_or_deduct = ($adj_amount < 0) ? 2 : 1;
                } elseif ($key == 'LWP') {
                    $salaryDetails->salary_details_type = Payroll::SALARYDETAILS['LWP'];
                    $salaryDetails->amount = $lwp_amount;
                    $salaryDetails->add_or_deduct = 2; // deduct
                } elseif ($key == 'LOAN') {
                    $salaryDetails->salary_details_type = Payroll::SALARYDETAILS['LOAN'];
                    $salaryDetails->amount = $loan_amount;
                    $salaryDetails->add_or_deduct = 2; // deduct
                }
                $salaryDetails->save();
            }

            foreach($individualSalary->individualSalaryBreakdowns as $breakDown){
                $salaryGeneratedBreakdown = new SalaryGeneratedBreakdown();
                $salaryGeneratedBreakdown->employee_id = $employee->id;
                $salaryGeneratedBreakdown->salary_history_id = $salaryHistory->id;
                $salaryGeneratedBreakdown->name = $breakDown->name;
                $salaryGeneratedBreakdown->amount = $gross_salary * ($breakDown->percentage/100);
                $salaryGeneratedBreakdown->percentage = $breakDown->percentage;
                $salaryGeneratedBreakdown->is_basic = $breakDown->is_basic;
                $salaryGeneratedBreakdown->save();
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }

        // dd($individualSalary);
        // dd($salaryDetails);

        // dd('ok');
        return true;

    }
}
