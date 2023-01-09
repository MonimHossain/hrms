<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterviewQstMst extends Model
{
    protected $guarded = [];

    public function labels()
    {
        return $this->hasMany('App\InterviewQstChd', 'mst_id', 'id');
    }
}
