<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceLib extends Model
{
    protected $table = 'resource_lib';
    protected $fillable = [
        'employee_id',
        'name',
        'note',
        'file',
        'status',
        'created_at'
    ];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function resourceLibraryFilter()
    {
        return $this->hasMany('App\ResourceLibFilter', 'resource_lib_id', 'id');
    }
    
    public function employeeDepartmentProcess()
    {
        return $this->hasMany('App\EmployeeDepartmentProcess', 'employee_id', 'employee_id');
    }

    public function resourceLibFilter()
    {
        return $this->hasMany('App\ResourceLibFilter', 'employee_id', 'employee_id');
    }
}
