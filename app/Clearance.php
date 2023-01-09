<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    protected $table = 'clearance';

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }
}
