<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YearlyAppraisalChd extends Model
{
    protected $guarded = [];

    protected $casts = [
        'recommendation_for' => 'array'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\YearlyAppraisalMst', 'y_a_mst_id', 'id');
    }

    public function recommendBy()
    {
        return $this->belongsTo('App\Employee', 'recommendation_by', 'id');
    }
}
