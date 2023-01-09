<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RosterChangeRequest extends Model
{
    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function roster(){
        return $this->belongsTo('App\Roster');
    }
}
