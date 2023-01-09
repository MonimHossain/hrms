<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveReason extends Model
{
    protected $fillable = ['leave_reason'];


    public function leave()
    {
        return $this->belongsTo('App\Leave');
    }
}
