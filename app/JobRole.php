<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    public function employeeJourney()
    {
        return $this->belongsTo('App\EmployeeJourney');
    }

    public function employeeJourneyArchive()
    {
        return $this->belongsTo('App\EmployeeJourneyArchive');
    }
}
