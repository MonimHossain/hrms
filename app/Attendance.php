<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'roster_start',
        'roster_end',
        'punch_in',
        'punch_out',
        'work_hours',
        'status',
        'remarks',
        'created_by',
        'updated_by'
    ];


    public function employee(){
        return $this->belongsTo('App\Employee');
    }


    // accessors
    public function getDayOfTheWeekAttribute(){
        $weekMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        $dayOfTheWeek = \Carbon\Carbon::create($this->date)->dayOfWeek;
        return $weekMap[$dayOfTheWeek];
    }
}
