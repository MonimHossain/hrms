<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualOtherAllowance extends Model
{
    protected $fillable = [
        'employee_id',
        'individual_salary_id',
        'adjustment_type_id',
        'type',
        'amount',
        'remarks',
    ];


    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    // public function salaries(){
    //     return $this->belongsToMany('App\IndividualSalary', 'individual_salary_other_allowance_pivot', 'allowance_id', 'salary_id')->withTimestamps();
    // }

    public function individualSalary()
    {
        return $this->belongsTo('App\IndividualSalary');
    }

    public function adjustmentType()
    {
        return $this->hasOne('App\AdjustmentType', 'id', 'adjustment_type_id');
    }

}
