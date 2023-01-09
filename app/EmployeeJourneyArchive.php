<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeJourneyArchive extends Model
{
    use HasUserStamps, SoftDeletes;


    protected $dates = ['deleted_at'];
    protected $fillable = [
        'employee_id',
        'employer_id',
        'process_id',
        'process_segment_id',
        'designation_id',
        'job_role_id',
        'department_id',
        'employment_type_id',
        'employee_status_id',
        'sup1',
        'sup2',
        'hod',
        'doj',
        'lwd',
        'contract_start_date',
        'contract_end_date',
        'process_doj',
        'process_lwd',
        'probation_start_date',
        'probation_period',
        'probation_remarks',
        'permanent_doj',
        'new_role_doj',
        'is_fixed_officetime',
    ];


    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function process()
    {
        return $this->hasOne('App\Process', 'id', 'process_id');
    }

    public function processSegment()
    {
        return $this->hasOne('App\ProcessSegment', 'id', 'process_segment_id');
    }

    public function designation()
    {
        return $this->hasOne('App\Designation', 'id', 'designation_id');
    }

    public function jobRole()
    {
        return $this->hasOne('App\JobRole', 'id', 'job_role_id');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function employmentType()
    {
        return $this->hasOne('App\EmploymentType', 'id', 'employment_type_id');
    }

    public function employeeStatus()
    {
        return $this->hasOne('App\EmployeeStatus', 'id', 'employee_status_id');
    }

    public function supervisor1()
    {
        return $this->hasOne('App\Employee', 'id', 'sup1');
    }

    public function supervisor2()
    {
        return $this->hasOne('App\Employee', 'id', 'sup2');
    }

    public function headOfDepartment()
    {
        return $this->hasOne('App\Employee', 'id', 'hod');
    }

}
