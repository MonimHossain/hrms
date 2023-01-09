<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class AppraisalFilterQuestionList extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    public function questionFilter()
    {
        return $this->belongsTo('App\AppraisalQuestionFilter', 'appraisal_filter_id', 'id');
    }

    public function questionList()
    {
        return $this->hasOne('App\AppraisalQstMst', 'id', 'appraisal_qst_mst_id');
    }


}
