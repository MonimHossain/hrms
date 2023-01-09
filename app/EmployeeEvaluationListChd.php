<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluationListChd extends Model
{

    protected $guarded = [];

    public function questions()
    {
        return $this->hasOne('App\AppraisalQstMst', 'id', 'qst_no');
    }

    public function qstList()
    {
        return $this->hasMany('App\AppraisalQstChd', 'mst_id', 'qst_no');
    }
}
