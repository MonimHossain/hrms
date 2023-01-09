<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRule extends Model
{
    protected $fillable = ['team_id', 'rule'];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function leave()
    {
        return $this->belongsTo('App\Leave');
    }
}
