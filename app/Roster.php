<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $guarded =[];

    public function rosterRequest(){
        return $this->hasMany('App\RosterRequest', 'roster_id', 'id');
    }
    public function rosterChangeRequest(){
        return $this->hasMany('App\RosterChangeRequest', 'roster_id', 'id');
    }



    // accessors
    public function getRosterTimeAttribute(){
        return "{$this->roster_start} - {$this->roster_end}";
    }
}
