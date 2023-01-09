<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClosingClearanceStatus extends Model
{
    protected $guarded = [];

    protected $casts = [
        'hr_checklist' => 'array',
        'it_checklist' => 'array',
        'admin_checklist' => 'array',
        'accounts_checklist' => 'array',
        'own_dept_checklist' => 'array',
    ];


    public function employeeByApplication()
    {
        return $this->hasOne('App\ClosingApplication', 'id', 'closing_applications_id');
    }

}
