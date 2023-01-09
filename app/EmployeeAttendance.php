<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasUserStamps;
    protected $fillable = [
        'employee_id',
        'employer_id',
        'date',
        'attendance_type',
        'status',
        'updated_by',
        'created_by'
    ];


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
