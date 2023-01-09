<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryGeneratedBreakdown extends Model
{
    protected $fillable = [
        'employee_id',
        'salary_history_id',
        'name',
        'amount',
        'percentage',
        'is_basic',
        'created_by',
        'updated_by',
    ];

    public function salaryHistory()
    {
        return $this->belongsTo('App\salaryHistory', 'salary_history_id');
    }
}
