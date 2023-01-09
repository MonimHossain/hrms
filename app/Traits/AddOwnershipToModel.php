<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AddOwnershipToModel{

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            //$userid = (!Auth::guest()) ? Auth::user()->id : null ;
            $userid = (auth()->user()->employeeDetails) ? auth()->user()->employee_id : Null ;
            $model->created_by = $userid;
            $model->updated_by = $userid;
        });

        static::updating(function($model)
        {
            $userid = (auth()->user()->employeeDetails) ? auth()->user()->employee_id : Null ;
            $model->updated_by = $userid;
        });
    }


}
