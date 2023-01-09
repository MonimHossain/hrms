<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use App\Traits\CasecadeSoftDelete;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Center;

class Division extends Model
{
    use SoftDeletes, HasUserStamps;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function centers()
    {
        return $this->hasMany('App\Center', 'division_id', 'id');
    }
}
