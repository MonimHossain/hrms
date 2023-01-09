<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RosterRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'date'
    ];
    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function roster(){
        return $this->belongsTo('App\Roster');
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
