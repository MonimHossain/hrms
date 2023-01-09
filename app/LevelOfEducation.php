<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelOfEducation extends Model
{
    public function education(){
        return $this->belongsTo('App\Education');
    }
}
