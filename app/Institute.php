<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = ['name'];

    //public function education(){
    //    return $this->belongsTo('App\Education');
    //}
}
