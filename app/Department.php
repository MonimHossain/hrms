<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes, HasUserStamps, AddOwnershipToModel;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    //public function employeeJourney()
    //{
    //    return $this->belongsTo('App\EmployeeJourney');
    //}


    //public function employeeJourneyArchive()
    //{
    //    return $this->belongsTo('App\EmployeeJourneyArchive');
    //}

    /**
     * The centers that belong to the department.
     */
    public function centers()
    {
        return $this->belongsToMany('App\Center');
    }

    //public function processes()
    //{
    //    return $this->hasMany('App\Process', 'department_id', 'id');
    //}

    public function processes()
    {
        return $this->belongsToMany('App\Process');
    }

    public function employeeDepartmentProcess()
    {
        return $this->belongsTo('App\EmployeeDepartmentProcess');
    }

    public function getEmployeeDepartmentProcesses()
    {
        return $this->hasMany('App\EmployeeDepartmentProcess', 'department_id', 'id');
    }




}
