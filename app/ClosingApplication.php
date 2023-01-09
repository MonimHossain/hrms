<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ClosingApplication extends Model
{
    protected $guarded = [];

    public function closingClearanceStatus()
    {
        return $this->hasOne('App\ClosingClearanceStatus', 'closing_applications_id', 'id');
    }

    public function exitInterviewEvaluation()
    {
        return $this->hasOne('App\ExitInterviewEvaluation', 'application_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function supervisor()
    {
        return $this->hasOne('App\Employee', 'id', 'supervisor_by');
    }

    public function teamlead()
    {
        return $this->hasOne('App\Employee', 'id', 'team_lead_by');
    }

    public function departmentProcess(){
        return $this->hasMany('App\EmployeeDepartmentProcess', 'employee_id', 'employee_id');
    }

    public function closingApplication()
    {
        return $this->belongsTo('App\FnfHistory', 'id', 'application_id');
    }


}
