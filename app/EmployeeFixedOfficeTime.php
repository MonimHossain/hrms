<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeFixedOfficeTime extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'employee_id',
        'day',
        'roster_start',
        'roster_end',
        'is_offday',
        'created_by',
        'updated_by',
    ];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
