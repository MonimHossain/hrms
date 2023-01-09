<?php

namespace App\Http\Forms\Loan;

use App\Http\Forms\Form;
use App\LoanApplication;
use App\Utils\ReferenceNumber;


class LoanApplicationObj extends Form {

    protected $rules = [
        'loan_type' => 'required',
        'interval' => 'required',
        'amount' => 'required|numeric',
        'remarks' => 'required',
    ];

    public function saveData()
    {
        $loanApplication = new LoanApplication();
        $data = [
            'loan_type' => $this->loan_type,
            'employee_id' => auth()->user()->employee_id,
            'interval' => $this->interval,
            'due_interval' => $this->interval,
            'amount' => $this->amount,
            'due_amount' => $this->amount,
            'remarks' => $this->remarks,
            'reference_id' => $this->generateRefNumber(),
            'status' => 1,
        ];
        return $loanApplication->create($data);
    }


    public function generateRefNumber(){
        $countDocAndDocument = LoanApplication::select('id')->max('id') + 1;
        return ReferenceNumber::AppointmentLetter.date("ymd").str_pad($countDocAndDocument, 6, "0", STR_PAD_LEFT);
    }



}
