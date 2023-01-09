<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamLeaveStatus extends Model
{

    protected $table = 'team_leave_status';
    protected $primaryKey = "employee_id";
    public $incrementing = false;


}
