<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ApprovalProcess;
use App\SetLeave;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'subject',
        'description',
        'start_date',
        'end_date',
        'leave_reason_id',
        'leave_type',
        'half_day',
        'leave_location',
        'resume_date',
        'quantity',
        'leave_status',
        'leave_days',
        'from_forwarded_el',
        'leave_rule_id',
        'supervisor_approved_by',
        'hot_approved_by',
        'rejected_by',
        'cancel_request',
        'cancel_request',
        'cancelled_by',
        'remarks',
        'created_by',
        'updated_by'
    ];

    protected $casts = ['leave_days' => 'array'];


    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function employeeJourney()
    {
        return $this->belongsTo('App\EmployeeJourney');
    }

//    public function leaves()
//    {
//        return $this->morphMany('App\Leave', 'approvalable');
//    }

//    public function approvalProcess()
//    {
//        return $this->hasMany('App\ApprovalProcess');
//    }

    public function leaveReason()
    {
        return $this->hasOne('App\LeaveReason', 'id', 'leave_reason_id');
    }

    public function leaveType()
    {
        return $this->hasOne('App\LeaveType', 'id', 'leave_type_id');
    }

    public function leaveRules()
    {
        return $this->hasOne('App\LeaveRule', 'id', 'leave_rule_id');
    }

    public function supervisorApprovedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'supervisor_approved_by');
    }

    public function hotApprovedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'hot_approved_by');
    }

    public function rejectedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'rejected_by');
    }

    public function leaveDocuments(){
        return $this->hasMany('App\LeaveDocument', 'leave_id', 'id');
    }
}
