<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualSalaryIncrement extends Model
{
    protected $fillable = [
        'employee_id',
        'individual_salary_id',
        'type',

        'last_gross_salary',
        'current_gross_salary',
        'incremented_amount',
        'pf',
        'pf_status',
        'tax',
        'tax_status',
        'total_deduction',
        'payable',

        'applicable_from',
        'applicable_to',

        'last_hourly_rate',
        'current_hourly_rate',
        'incremented_hourly_rate',

        'salary_status',

        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function individualSalary()
    {
        return $this->belongsTo('App\IndividualSalary');
    }
}
