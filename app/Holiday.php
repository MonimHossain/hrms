<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    //
    protected $fillable = ['title', 'start_date', 'end_date', 'description', 'religion'];


    public function centers()
    {
        return $this->belongsToMany('App\Center')->withPivot('division_id');
    }

    // public function division()
    // {
    //     return $this->hasOne('App\Division', 'id', 'division_id');
    // }


}
