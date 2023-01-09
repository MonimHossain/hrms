<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessSegment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function employeeJourney()
    {
        return $this->belongsTo('App\EmployeeJourney', 'process_segment_id');
    }

    public function employeeDepartmentProcess()
    {
        return $this->belongsTo('App\EmployeeDepartmentProcess', 'process_segment_id');
    }

    public function employeeJourneyArchive()
    {
        return $this->belongsTo('App\EmployeeJourneyArchive', 'process_segment_id');
    }

    public function process()
    {
        return $this->belongsTo('App\Process');
    }


}
