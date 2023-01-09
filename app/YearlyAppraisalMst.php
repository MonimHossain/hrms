<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YearlyAppraisalMst extends Model
{

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo('App\Department', 'dept_id', 'id');
    }

}
