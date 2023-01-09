<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;

class DocumentReqHistory extends Model
{
    use AddOwnershipToModel;

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function processedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'processed_by');
    }

    public function document()
    {
        return $this->hasOne('App\DocSetup', 'id', 'type_id');
    }

    public function employeeDepartmentProcess()
    {
        return $this->hasOne('App\EmployeeDepartmentProcess', 'employee_id', 'employee_id');
    }

}
