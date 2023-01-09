<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppraisalQuestionFilter extends Model
{

    public function division()
    {
        return $this->hasOne('App\Division', 'id', 'division_id');
    }

    public function center()
    {
        return $this->hasOne('App\Center', 'id', 'center_id');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function process()
    {
        return $this->hasOne('App\Process', 'id', 'process_id');
    }

    public function processSegment()
    {
        return $this->hasOne('App\ProcessSegment', 'id', 'process_segment_id');
    }

    public function evaluationName()
    {
        return $this->belongsTo('App\AppraisalEvaluationName', 'name', 'id');
    }

    public function filterQuestionList()
    {
        return $this->hasMany('App\AppraisalFilterQuestionList', 'appraisal_filter_id', 'id');
    }
}
