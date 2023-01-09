<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendanceSummary extends Model
{
    use HasUserStamps;
    protected $table = 'employee_attendance_summary';

    public function employee()
    {
        return $this->belongsTo('App\Employee');
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
