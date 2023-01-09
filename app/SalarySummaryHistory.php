<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalarySummaryHistory extends Model
{
    protected $table = 'salary_summary_history';

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function employmentType()
    {
        return $this->hasOne('App\EmploymentType', 'id', 'employment_type_id');
    }
}
