<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CasecadeSoftDelete;


class Process extends Model
{
    use SoftDeletes, CasecadeSoftDelete;

    protected $dates = ['deleted_at'];
    protected $casecadeSoftDeleteMethod = 'processSegments'; // Casecade soft delete
    protected $guarded =[];


    public function employeeJourney()
    {
        return $this->belongsTo('App\EmployeeJourney');
    }

    public function employeeDepartmentProcess()
    {
        return $this->belongsTo('App\EmployeeDepartmentProcess');
    }

    public function employeeJourneyArchive()
    {
        return $this->belongsTo('App\EmployeeJourneyArchive');
    }

    //public function department()
    //{
    //    return $this->belongsTo('App\Department');
    //}

    public function department()
    {
        return $this->belongsToMany('App\Department');
    }

    public function processSegments()
    {
        return $this->hasMany('App\ProcessSegment', 'process_id', 'id');
    }

    /*Khayrul*/
    public function employeeDeptProcess()
    {
        return $this->hasOne('App\EmployeeDepartmentProcess', 'process_id', 'id') ;
    }


}
