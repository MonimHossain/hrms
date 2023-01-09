<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceChangeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'roster_start',
        'roster_end',
        'punch_in',
        'punch_out',
        'out_of_office',
        'is_adjusted_day_off',
        'first_approve_status',
        'final_approve_status',
        'remarks',
        'status'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
