<?php

namespace App\Observers;

use App\Employee;
use App\Services\ProfileCompletionService;

class EmployeeObserver
{
    /**
     * Handle the employee "creating" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function creating(Employee $employee)
    {
        //$profileCompletion = new ProfileCompletionService($employee);
        //$percentage = $profileCompletion->profile_progress();
        //$employee->profile_completion = $percentage;
    }

    /**
     * Handle the employee "created" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "updating" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function updating(Employee $employee)
    {
        //dd($employee->id. ' Updating');
        //$profileCompletion = new ProfileCompletionService($employee);
        //$percentage = $profileCompletion->profile_progress();
        //$employee->profile_completion = $percentage;
    }

    /**
     * Handle the employee "updated" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "saving" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function saving(Employee $employee)
    {
        //dd($employee->id. ' saving');
        $profileCompletion = new ProfileCompletionService($employee);
        $percentage = $profileCompletion->profile_progress();
        $employee->profile_completion = $percentage;
    }

    /**
     * Handle the employee "deleted" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "restored" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "force deleted" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
