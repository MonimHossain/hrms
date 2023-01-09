<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluationListMst extends Model
{
    protected $guarded = [];

//    protected $casts = [
//        'recommendation_for' => 'array'
//    ];

//    public function setRecommendationDataAttribute($value)
//    {
//        $this->attributes['recommendation_for'] = json_encode($value);
//    }

    public function evaluationList()
    {
        return $this->hasMany('App\EmployeeEvaluationListChd', 'evaluation_mst', 'id');
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

    public function updatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'lead_id');
    }

    public function team()
    {
        return $this->hasOne('App\Team', 'id', 'team_id');
    }

//    public function appraisalQstMst()
//    {
//        return $this->
//    }
}
