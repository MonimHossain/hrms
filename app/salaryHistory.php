<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salaryHistory extends Model
{
    protected $fillable = [
        'employee_id',
        'employment_type_id',
        'month',
        'start_date',
        'end_date',
        'gross_salary',
        'payable_amount',
        'kpi',
        'is_hold',
        'created_by',
        'updated_by',
        'release_by',
        'release_at',
        'release_remarks'
    ];
    protected $table = 'salary_history';

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function salaryDetails()
    {
        return $this->hasMany('App\SalaryDetail', 'salary_history_id', 'id');
    }

    public function salaryGeneratedBreakdowns()
    {
        return $this->hasMany('App\SalaryGeneratedBreakdown', 'salary_history_id', 'id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'updated_by');
    }
}
