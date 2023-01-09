<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $guarded = [];

    protected $dates = ['created_at'];


    public function approvedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'approved_by');
    }


    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }


    public function loanType()
    {
        return $this->hasOne('App\LoanType', 'id', 'loan_type');
    }


    public function loanGeneralApp()
    {
        return $this->hasOne('App\LoanGeneralApplication', 'loan_id', 'id');
    }

}
