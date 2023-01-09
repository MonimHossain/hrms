<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = ['leave_type', 'short_code'];

    public function leaveBalanceSettings(){
        return $this->hasMany('App\LeaveBalanceSetting', 'leave_type_id', 'id');
    }
}
