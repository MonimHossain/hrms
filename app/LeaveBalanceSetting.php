<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveBalanceSetting extends Model
{
    protected $fillable = ['leave_type_id', 'quantity', 'employment_type_id'];

    public function employmentType()
    {
        return $this->hasOne('App\EmploymentType', 'id', 'employment_type_id');
    }

    public function leaveType(){
        return $this->belongsTo('App\LeaveType');
    }
}
