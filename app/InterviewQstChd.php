<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterviewQstChd extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->hasOne('App\InterviewQstMst', 'id', 'mst_id');
    }
}
