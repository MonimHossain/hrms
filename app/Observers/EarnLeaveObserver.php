<?php

namespace App\Observers;

use App\EarnLeave;
use App\Employee;
use App\Scopes\DivisionCenterScope;
use App\Utils\LeaveStatus;

class EarnLeaveObserver
{
    public function earnBalanceGenerate($earnLeave)
    {
        // generate earn leave balance to the main leave balance table
        //$employee = $earnLeave->employee;
        $employee = Employee::whereId($earnLeave->employee_id)->withoutGlobalScope(DivisionCenterScope::class)->first();
        if($employee && !$employee->leaveBalances()->where('year', $earnLeave->year)->where('employment_type_id', $employee->employeeJourney->employment_type_id)->where('leave_type_id', LeaveStatus::EARNED)->exists()){
        //if($employee && !$employee->leaveBalances()->where('year', date("Y"))->where('employment_type_id', $employee->employeeJourney->employment_type_id)->where('leave_type_id', LeaveStatus::EARNED)->exists()){
            $employee->leaveBalances()->create([
                'year' => $earnLeave->year,
                'probation_start_date' => $employee->employeeJourney->probation_start_date ?? null,
                'permanent_doj' => $employee->employeeJourney->permanent_doj ?? null,
                'employment_type_id' => $employee->employeeJourney->employment_type_id,
                'leave_type_id' => LeaveStatus::EARNED,
                'total' => $earnLeave->total_balance,
                'used' => (session()->has('earned_used')) ? session('earned_used') : 0,
                'remain' => (session()->has('earned_used')) ? $earnLeave->total_balance - session('earned_used') : $earnLeave->total_balance,
                'is_usable' => (session()->has('earned_used')) ? 1 : $earnLeave->is_usable,
            ]);
        }
        // elseif($employee && $leaveBalance = $employee->leaveBalances()->where('year', date("Y"))->where('employment_type_id', $employee->employeeJourney->employment_type_id)->where('leave_type_id', LeaveStatus::EARNED)->first()){
        //     $leaveBalance->total = $earnLeave->forwarded_balance;
        //     $leaveBalance->used = (session()->has('earned_used')) ? session('earned_used') : 0;
        //     $leaveBalance->remain = (session()->has('earned_used')) ? $earnLeave->forwarded_balance - session('earned_used') : $earnLeave->forwarded_balance;
        //     $leaveBalance->save();
        // }

        session()->forget('earned_used');
    }
    /**
     * Handle the earn leave "created" event.
     *
     * @param  \App\EarnLeave  $earnLeave
     * @return void
     */
    public function created(EarnLeave $earnLeave)
    {
        //// generate earn leave balance to the main leave balance table
        //$employee = $earnLeave->employee;
        //$employee->leaveBalances()->create([
        //    'year' => date("Y"),
        //    'probation_start_date' => $employee->employeeJourney->probation_start_date ?? null,
        //    'permanent_doj' => $employee->employeeJourney->permanent_doj ?? null,
        //    'employment_type_id' => $employee->employeeJourney->employment_type_id,
        //    'leave_type_id' => LeaveStatus::EARNED,
        //    'total' => $earnLeave->total_balance,
        //    'used' => (session()->has('earned_used')) ? session('earned_used') : 0,
        //    'remain' => (session()->has('earned_used')) ? $earnLeave->total_balance - session('earned_used') : $earnLeave->total_balance,
        //    'is_usable' => (session()->has('earned_used')) ? 1 : $earnLeave->is_usable,
        //]);
        //session()->forget('earned_used');
        $this->earnBalanceGenerate($earnLeave);
    }

    /**
     * Handle the earn leave "saved" event.
     *
     * @param  \App\EarnLeave  $earnLeave
     * @return void
     */
    public function saved(EarnLeave $earnLeave)
    {
        //// generate earn leave balance to the main leave balance table
        //$employee = $earnLeave->employee;
        //$employee->leaveBalances()->create([
        //    'year' => date("Y"),
        //    'probation_start_date' => $employee->employeeJourney->probation_start_date ?? null,
        //    'permanent_doj' => $employee->employeeJourney->permanent_doj ?? null,
        //    'employment_type_id' => $employee->employeeJourney->employment_type_id,
        //    'leave_type_id' => LeaveStatus::EARNED,
        //    'total' => $earnLeave->total_balance,
        //    'used' => (session()->has('earned_used')) ? session('earned_used') : 0,
        //    'remain' => (session()->has('earned_used')) ? $earnLeave->total_balance - session('earned_used') : $earnLeave->total_balance,
        //    'is_usable' => (session()->has('earned_used')) ? 1 : $earnLeave->is_usable,
        //]);
        //session()->forget('earned_used');
        $this->earnBalanceGenerate($earnLeave);
    }

    /**
     * Handle the earn leave "updated" event.
     *
     * @param  \App\EarnLeave  $earnLeave
     * @return void
     */
    public function updated(EarnLeave $earnLeave)
    {
        //
    }

    /**
     * Handle the earn leave "deleted" event.
     *
     * @param  \App\EarnLeave  $earnLeave
     * @return void
     */
    public function deleted(EarnLeave $earnLeave)
    {
        //
    }

    /**
     * Handle the earn leave "restored" event.
     *
     * @param  \App\EarnLeave  $earnLeave
     * @return void
     */
    public function restored(EarnLeave $earnLeave)
    {
        //
    }

    /**
     * Handle the earn leave "force deleted" event.
     *
     * @param  \App\EarnLeave  $earnLeave
     * @return void
     */
    public function forceDeleted(EarnLeave $earnLeave)
    {
        //
    }
}
