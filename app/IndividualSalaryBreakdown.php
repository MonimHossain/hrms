<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualSalaryBreakdown extends Model
{
    protected $fillable = [
        'employee_id',
        'individual_salary_id',
        'name',
        'percentage'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    // public function salaries(){
    //     return $this->belongsToMany('App\IndividualSalary', 'individual_salary_breakdown_pivot', 'breakdown_id', 'salary_id')->withTimestamps();
    // }

    public function individualSalary()
    {
        return $this->belongsTo('App\IndividualSalary');
    }
}
