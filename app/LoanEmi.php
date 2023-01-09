<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanEmi extends Model
{
    protected $guarded = [];

    protected $dates = ['emi_date'];

    public function loan()
    {
        return $this->hasOne('App\LoanApplication', 'id', 'loan_id');
    }


}
