<?php

namespace App;

use App\Traits\HasUserStamps;
use App\Utils\TeamMemberType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDepartmentProcess extends Model
{
    use SoftDeletes, HasUserStamps;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'employee_id',
        'process_id',
        'process_segment_id',
        'department_id',
        'team_id',
        'added_at',
        'removed_at',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function process()
    {
        return $this->hasOne('App\Process', 'id', 'process_id');
    }

    public function processSegment()
    {
        return $this->hasOne('App\ProcessSegment', 'id', 'process_segment_id');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function employee_team()
    {
        return $this->hasOne('App\EmployeeTeam', 'employee_id', 'employee_id');
    }

    public function employeeEvaluationList()
    {
        return $this->belongsTo('App\EmployeeEvaluationListMst', 'employee_id', 'employee_id');
    }

    public function teamEvaluationStatus()
    {
        return $this->belongsTo('App\TeamEvaluationStatus', 'team_id', 'team_id');
    }

    public function teams()
    {
        return $this->hasOne('App\Team', 'id', 'team_id');
    }

}
