<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;
use App\DocumentHeaderTemplate;

class Document extends Model
{
    use AddOwnershipToModel;
    protected $guarded = [];


    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function employeeDepartmentProcess()
    {
        return $this->hasOne('App\EmployeeDepartmentProcess', 'employee_id', 'employee_id');
    }

    public function processedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function document()
    {
        return $this->hasOne('App\DocSetup', 'id', 'doc_type_id');
    }

    public function padTemplate()
    {
        return $this->hasOne('App\DocumentHeaderTemplate', 'id', 'document_header_id');
    }






}
