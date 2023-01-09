<?php

namespace App\Http\Forms\Loan;

use App\Http\Forms\Form;
use App\LoanType;




class LoanTypeObj extends Form {

    protected $rules = [
        'loan_type' => 'required|min:3',
        'terms_and_condition' => 'required',
        'max_amount' => 'required',
        'interval' => 'required'
    ];

    public function saveData()
    {

        $loanType = new LoanType;
        $data = [
            'loan_type' => $this->loan_type,
            'content' => $this->terms_and_condition,
            'max_amount' => $this->max_amount,
            'interval' => $this->interval
        ];
        return $loanType->create($data);
    }



}
