<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeStatus extends Model
{
    use SoftDeletes, HasUserStamps, AddOwnershipToModel;

    protected $dates = ['deleted_at'];

    protected $guarded =[];

    public function employeeJourney()
    {
        return $this->belongsTo('App\EmployeeJourney');
    }

    public function employeeJourneyArchive()
    {
        return $this->belongsTo('App\EmployeeJourneyArchive');
    }
}
