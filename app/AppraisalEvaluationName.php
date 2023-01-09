<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class AppraisalEvaluationName extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function evaluationList()
    {
        return $this->hasMany('App\EmployeeEvaluationListMst', 'evaluation_id', 'id');
    }

    public function evaluationFilter()
    {
        return $this->hasOne('App\AppraisalQuestionFilter', 'name', 'id');
    }

    public function employeeEvaluationList()
    {
        return $this->hasMany('App\EmployeeEvaluationListMst', 'evaluation_id', 'id');
    }

    public function leadEvaluationList()
    {
        return $this->hasMany('App\LeadEvaluationListMst', 'evaluation_id', 'id');
    }

    public function teamEvaluationStatus()
    {
        return $this->hasMany('App\TeamEvaluationStatus', 'evaluation_id', 'id');
    }






}
