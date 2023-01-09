<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class EmployeeClosing extends Model
{
    use HasUserStamps;
    protected $guarded = [];


    public function checklist()
    {
        return $this->hasOne('App\ClearanceChecklist', 'id', 'checklist_id');
    }

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'approved_by');
    }

    public function user()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }




}
