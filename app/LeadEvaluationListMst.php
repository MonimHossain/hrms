<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadEvaluationListMst extends Model
{
    protected $guarded = [];

    public function evaluationList()
    {
        return $this->hasMany('App\LeadEvaluationListChd', 'evaluation_mst', 'id');
    }

    /*public function questions()
    {
        return $this->hasOne('App\AppraisalQstMst', 'qst_no', 'id');
    }*/

    public function evaluationName()
    {
        return $this->hasOne('App\AppraisalEvaluationName', 'id', 'evaluation_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function teamLead()
    {
        return $this->hasOne('App\Employee', 'id', 'lead_id');
    }

    public function team()
    {
        return $this->hasOne('App\Team', 'id', 'team_id');
    }


}
