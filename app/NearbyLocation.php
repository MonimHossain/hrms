<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NearbyLocation extends Model
{

    protected $fillable = ['center_id', 'nearby'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function center()
    {
        return $this->belongsTo('App\Center');
    }
}
