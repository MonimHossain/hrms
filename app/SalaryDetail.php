<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'salary_history_id',
        'salary_details_type',
        'amount',
        'add_or_deduct',
        'created_by',
        'updated_by',
    ];

    public function salaryHistory()
    {
        return $this->belongsTo('App\salaryHistory', 'salary_history_id');
    }
}
