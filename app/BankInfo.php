<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{

    protected $fillable = ['bank_name'];

    public function bankBranches(){
        return $this->hasMany('App\BankBranch', 'bank_id', 'id');
    }

    public function individualSalary()
    {
        return $this->belongsTo('App\IndividualSalary');
    }
}
