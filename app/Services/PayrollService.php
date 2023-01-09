<?php

namespace App\Services;

use App\IndividualSalaryIncrement;
use App\ProvidentFundSetting;
use App\TaxSetting;
use Carbon\Carbon;

class PayrollService
{
    private $individualSalary, $request;

    public function __construct($individualSalary, $request = null)
    {
        $this->individualSalary = $individualSalary;
        $this->request = $request;
    }

    // increment salary
    public function incrementSalary()
    {
        $request = $this->request;
        $individualSalary = $this->individualSalary;
        $previousIncrement = $individualSalary->incrementSalary()->where('salary_status', 1)->first(); // previous incremented data

        if ($request->get('type') == 0) {
            $individualSalaryIncrement = new IndividualSalaryIncrement();
            $individualSalaryIncrement->employee_id = $request->get('employee_id');
            $individualSalaryIncrement->individual_salary_id = $request->get('individual_salary_id');
            $individualSalaryIncrement->type = $request->get('type');
            $individualSalaryIncrement->applicable_from = Carbon::parse($request->get('applicable_from'))->format('Y-m-d');
            $individualSalaryIncrement->pf_status = 0;
            $individualSalaryIncrement->tax_status = 0;
            $individualSalaryIncrement->last_hourly_rate = $request->get('last_hourly_rate');
            $individualSalaryIncrement->current_hourly_rate = $request->get('current_hourly_rate');
            $individualSalaryIncrement->incremented_hourly_rate = $request->get('incremented_hourly_rate');
            $individualSalaryIncrement->salary_status = 1;
        } elseif ($request->get('type') == 1) {
            $totalDeduction = 0;
            $payable = 0;
            $pf = 0;
            $tax = 0;

            if ($individualSalary->pf_status == 1) {
                $pf = $this->pfCalculation($individualSalary);
                $totalDeduction += $pf;
            }
            if ($individualSalary->tax_status == 1) {
                $tax = $this->taxCalculate($individualSalary);
                $totalDeduction += $tax;
            }

            $otherAllowances = $this->otherAllowances($individualSalary);
            if ($otherAllowances['deduction'] > 0) {
                $totalDeduction += $otherAllowances['deduction'];
            }

            $payable = $request->get('current_gross_salary') - $totalDeduction;

            if ($otherAllowances['addition'] > 0) {
                $payable += $otherAllowances['addition'];
            }

            $individualSalaryIncrement = new IndividualSalaryIncrement();
            $individualSalaryIncrement->employee_id = $request->get('employee_id');
            $individualSalaryIncrement->individual_salary_id = $request->get('individual_salary_id');
            $individualSalaryIncrement->type = $request->get('type');
            $individualSalaryIncrement->last_gross_salary = $request->get('last_gross_salary');
            $individualSalaryIncrement->current_gross_salary = $request->get('current_gross_salary');
            $individualSalaryIncrement->incremented_amount = $request->get('incremented_amount');

            if ($individualSalary->pf_status == 1) {
                $individualSalaryIncrement->pf_status = 1;
                $individualSalaryIncrement->pf = $pf;
            } else {
                $individualSalaryIncrement->pf_status = 0;
                $individualSalaryIncrement->pf = null;
            }

            if ($individualSalary->tax_status == 1) {
                $individualSalaryIncrement->tax_status = 1;
                $individualSalaryIncrement->tax = $tax;
            } else {
                $individualSalaryIncrement->tax_status = 0;
                $individualSalaryIncrement->tax = null;
            }
            $individualSalaryIncrement->total_deduction = $totalDeduction;
            $individualSalaryIncrement->payable = $payable;
            $individualSalaryIncrement->applicable_from = Carbon::parse($request->get('applicable_from'))->format('Y-m-d');
            $individualSalaryIncrement->salary_status = 1;
        }

        if ($individualSalaryIncrement->save()) {
            // $individualSalary->applicable_to = Carbon::parse($request->get('applicable_from'))->subDays(1)->format('Y-m-d');
            // $individualSalary->save();
            if ($previousIncrement) {
                $previousIncrement->applicable_to = Carbon::parse($request->get('applicable_from'))->subDays(1)->format('Y-m-d');
                $previousIncrement->salary_status = 0;
                $previousIncrement->save();
            }
            return true;
        } else {
            return false;
        }
    }

    // pf calculation
    public function pfCalculation($individualSalary)
    {
        $request = $this->request;
        $pf_settings = ProvidentFundSetting::first();
        $individualSalaryBreakdown = $individualSalary->individualSalaryBreakdowns;
        $grossSalary = $request->current_gross_salary;
        $basicSalary = $grossSalary * ($individualSalaryBreakdown->where('is_basic', 1)->first()->percentage / 100);
        $pf = $basicSalary * ($pf_settings->amount / 100);
        return $pf;
    }

    // tax calculation
    public function taxCalculate($individualSalary)
    {
        $request = $this->request;
        $tax_settings = TaxSetting::all();
        $individualSalaryBreakdown = $individualSalary->individualSalaryBreakdowns;
        $grossSalary = $request->current_gross_salary;
        $basicSalary = $grossSalary * ($individualSalaryBreakdown->where('is_basic', 1)->first()->percentage / 100);
        $yearlyBasicSalary = $basicSalary * 12;
        $taxPercentage = 0;
        foreach ($tax_settings as $tax) {
            if ($yearlyBasicSalary >= $tax->min) {
                $taxPercentage = $tax->amount;
            }
        }
        $tax = $grossSalary * ($taxPercentage / 100);
        return $tax;
    }

    // other allowance calculation
    public function otherAllowances($individualSalary)
    {
        $individualOtherAllowances = $individualSalary->individualOtherAllowances;
        $addition = 0;
        $deduction = 0;
        foreach ($individualOtherAllowances as $individualOtherAllowance) {
            if ($individualOtherAllowance->type == 'addition') {
                $addition += $individualOtherAllowance->amount;
            } elseif ($individualOtherAllowance->type == 'deduction') {
                $deduction += $individualOtherAllowance->amount;
            }
        }
        return [
            'addition' => $addition,
            'deduction' => $deduction
        ];
    }

    // get salary
    public function getIndividualSalary($individualSalary = null)
    {
        if ($individualSalary == null) {
            $individualSalary = $this->individualSalary;
        }
        return $individualSalary->getIndividualSalaryWithIncrement();
    }
}
