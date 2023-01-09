<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryHoldList extends Model
{
    protected $dates = ['month', 'created_at'];
    protected $guarded = [];


    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'updated_by');
    }



}
