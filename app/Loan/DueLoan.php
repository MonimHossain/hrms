<?php


namespace App\Loan;


use App\LoanApplication;
use App\Utils\Payroll;


class DueLoan implements Loan
{
    public function getInfo($id)
    {
        $result = LoanApplication::where('status', Payroll::LOAN['SHOWSTATUS']['APPROVED'])->where('due_amount', '>', 0)->get();
        return response($result, 200)
            ->header('Content-Type', 'text/plain');
    }

}
