<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kpi extends Model
{
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $table = 'kpis';


    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

}
