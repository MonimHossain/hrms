<?php

namespace App\Loan;



use App\LoanApplication;
use App\Utils\Payroll;


class EmiLoan implements Loan
{

    public function getInfo($id)
    {
        $data = LoanApplication::where('status', Payroll::LOAN['SHOWSTATUS']['APPROVED'])->where('due_amount', '>', 0)->get();

        echo response()->json($data);

    }

}
