<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    public function employeeJourney()
    {
        return $this->belongsTo('App\EmployeeJourney');
    }

    public function employeeJourneyArchive()
    {
        return $this->belongsTo('App\EmployeeJourneyArchive');
    }

    public function leaveBalanceSetting()
    {
        return $this->belongsTo('App\LeaveBalanceSetting');
    }
}
