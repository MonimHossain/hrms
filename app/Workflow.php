<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Process;
use App\TeamWorkflow;

class Workflow extends Model
{

    public function team()
    {
        return $this->belongsToMany('App\Team');
    }

    public function teamWorkflow()
    {
        return $this->belongsTo('App\TeamWorkflow', 'id');
    }
}
