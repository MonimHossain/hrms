<?php

namespace App\Services;

class ProfileCompletionService
{
    private $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function profile_progress(){
        $complete = 0;
        $total = 15;
        if ($this->employee->blood_group_id != null) $complete += 1;
        if ($this->employee->first_name != null) $complete += 1;
        if ($this->employee->last_name != null) $complete += 1;
        if ($this->employee->personal_email != null) $complete += 1;
        if ($this->employee->gender != null) $complete += 1;
        if ($this->employee->date_of_birth != null) $complete += 1;
        if ($this->employee->religion != null) $complete += 1;
        if ($this->employee->ssc_reg_num != null || $this->employee->nid != null || $this->employee->passport != null) $complete += 1;
        if ($this->employee->father_name != null) $complete += 1;
        if ($this->employee->mother_name != null) $complete += 1;
        if ($this->employee->present_address != null) $complete += 1;
        if ($this->employee->permanent_address != null) $complete += 1;
        if ($this->employee->contact_number != null) $complete += 1;
        if ($this->employee->marital_status != null) $complete += 1;
        if ($this->employee->educations()->count()) $complete += 1;

        return ($complete / $total) * 100;
    }
}
