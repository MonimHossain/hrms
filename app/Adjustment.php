<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    //protected $dates = ['created_at'];


    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'updated_by');
    }

    public function adjustmentType()
    {
        return $this->hasOne('App\AdjustmentType', 'id', 'adjustment_type');
    }
}
