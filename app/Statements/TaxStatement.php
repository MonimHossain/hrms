<?php


namespace App\Statements;


use App\Clearance;
use App\IndividualSalary;
use App\SalaryHoldList;
use App\Statements\Statement;
use App\Utils\Payroll;
use Carbon\Carbon;

class TaxStatement implements Statement
{
    private $month;
    private $year;
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function getStatement()
    {
        /*Start check salary hold*/
        $salaryHoldStatus = SalaryHoldList::whereYear('month', $this->year)->whereMonth('month', $this->month)->where('status', Payroll::SALARYHOLD['status']['Hold'])->get()->pluck('employee_id')->toArray();
        /*End check salary hold*/



         $resutl = IndividualSalary::where('type', Payroll::STATEMENT['status']['Active'])
             ->where('salary_status', Payroll::SALARYSTATUS['active'])
             ->where('tax_status', Payroll::SALARYSTATUS['active'])
             ->get()->map(function ($item) use ($salaryHoldStatus) {
                 $salary = $item->getIndividualSalaryWithIncrement();
             $data['employee_id'] = $salary->employee_id;
             $data['amount'] = $salary->tax;
             $data['remarks'] = '';
             $data['status'] = in_array($salary->employee_id, $salaryHoldStatus) ? 3 : 0;
             $data['month'] = $this->year.'-'.$this->month;
             return $data;
         })->toArray();

         return $resutl;

    }

}
