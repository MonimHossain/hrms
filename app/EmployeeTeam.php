<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTeam extends Model
{
    protected $table = 'employee_team';

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id', 'id');
    }
}
