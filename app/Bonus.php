<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasUserStamps;
    protected $dates = ['month', 'created_at'];
    protected $guarded = [];


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
}
