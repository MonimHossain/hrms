<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamEvaluationStatus extends Model
{
    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id', 'id');
    }

    public function LeadEvaluationListMaster()
    {
        return $this->hasMany('App\LeadEvaluationListMst', 'evaluation_id', 'evaluation_id');
    }

    public function employeeEvaluationListMaster()
    {
        return $this->hasMany('App\EmployeeEvaluationListMst', 'evaluation_id', 'evaluation_id');
    }

    public function evaluationName()
    {
        return $this->belongsTo('App\AppraisalEvaluationName', 'evaluation_id', 'id');
    }
}
