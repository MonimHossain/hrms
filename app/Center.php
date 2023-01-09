<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use SoftDeletes, HasUserStamps, AddOwnershipToModel;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    /**
     * The departments that belong to the center.
     */
    public function departments()
    {
        return $this->belongsToMany('App\Department');
    }

    public function nearbyLocation()
    {
        return $this->hasMany('App\NearbyLocation', 'center_id', 'id');
    }

    public function holidays()
    {
        return $this->belongsToMany('App\Holiday')->withPivot('division_id');
    }

}
