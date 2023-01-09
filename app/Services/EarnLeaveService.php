<?php


namespace App\Services;


use App\Employee;
use App\LeaveBalanceSetting;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Underscore\Types\Number;

class EarnLeaveService
{
    private $employee,
        $casualLeave,
        $sickLeave,
        $earnLeave,
        $present_year;

    public function __construct($employee)
    {
        $this->employee = $employee;
        $this->present_year = Carbon::now()->format('Y');

        $this->casualLeave = 10;
        $this->sickLeave = 14;
        $this->earnLeave = 16;
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    public function getEligibleDate()
    {
        return (($this->employee->employeeJourney) && ($this->employee->employeeJourney->permanent_doj)) ? $this->employee->employeeJourney->permanent_doj :
            ((($this->employee->employeeJourney) && ($this->employee->employeeJourney->probation_start_date)) ? $this->employee->employeeJourney->probation_start_date : null);
    }



    public function generateEarnBalance($leave, $forwarded = null)
    {
        if ($checkExist = $this->employee->earnLeaves()->where('year', $this->present_year)->first()) {
            $checkExist->save(); // to run observer and generate earn leave to the balance
            return false;
        }
        $eligible_date = $this->getEligibleDate();
        //dd($eligible_date);
        //$present_year = Carbon::now()->format('Y');
        if(!$leave){
            $quantity = 0;
        } else {
            $quantity = $leave->quantity;
        }
        $is_used = (Carbon::parse($eligible_date)->diffInMonths(Carbon::now()) > 12) ? 1 : 0;
        if (Carbon::parse($eligible_date)->format('Y') < $this->present_year) {
            $this->employee->earnLeaves()->create([
                'eligible_date' => $eligible_date,
                'year' => $this->present_year,
                'earn_balance' => $quantity,
                'forwarded_balance' => $forwarded,
                'total_balance' => ($quantity + $forwarded),
                'is_usable' => $is_used,
                //'is_usable' => ($forwarded) ? 1 : $is_used,
            ]);
        } else {
            $this->employee->earnLeaves()->create([
                'eligible_date' => $eligible_date,
                'year' => $this->present_year,
                'earn_balance' => round(($quantity / 12) * (12 - (Carbon::parse($eligible_date)->format('m') - 1))),
                'forwarded_balance' => $forwarded,
                'total_balance' => round(($quantity / 12) * (12 - (Carbon::parse($eligible_date)->format('m') - 1))) + $forwarded,
                'is_usable' => $is_used,
                //'is_usable' => ($forwarded) ? 1 : $is_used,
            ]);
        }
    }

    public function getJobTenure($year){
        $employee = $this->employee;
        return ($employee->employeeJourney->probation_start_date) ? Carbon::parse($employee->employeeJourney->probation_start_date)->diffInYears(Carbon::parse($year.'-1-1')->format('Y-m-d')) :
            (($employee->employeeJourney->permanent_doj) ? Carbon::parse($employee->employeeJourney->permanent_doj)->diffInYears(Carbon::parse($year.'-1-1')->format('Y-m-d')) : null);
    }


    public function generateEarnBalanceYearly($leave, $year, $forwarded = null){

        $employee = $this->employee;        
        $jobTenure = $this->getJobTenure($year);
        $eligible_date = $this->getEligibleDate();
        $date = Carbon::parse($this->present_year.Carbon::parse($eligible_date)->format('-m-d'))->format('Y-m-d');

        if ($checkExist = $this->employee->earnLeaves->where('year', $year)->first()) {
            if ($jobTenure >= 1 && $jobTenure < 2) {
                $previousLeave = $this->employee->leaveBalances->where('year', $year-1)->where('leave_type_id', LeaveStatus::EARNED)->first();
                if($forwarded == null){
                    if($previousLeave){
                        $forwarded = $previousLeave->remain;
                    }else {
                        $forwarded = 0;
                    }
                }
                $earnBalance = round(($leave->quantity / 12) * (12 - (Carbon::parse($date)->format('m') - 1)));
                $totalBalance = round(($leave->quantity / 12) * (12 - (Carbon::parse($date)->format('m') - 1))) + $forwarded;
                $totalBalance = ($totalBalance > 16) ? 16 : $totalBalance;
    
                $this->employee->earnLeaves()->update([
                    'eligible_date' => $eligible_date,
                    'year' => $year,
                    'earn_balance' => $earnBalance,
                    'forwarded_balance' => $forwarded,
                    'total_balance' => $totalBalance,
                    'is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0,
                ]);
    
            } elseif($jobTenure > 2) {
                $this->employee->earnLeaves()->update([
                    'eligible_date' => $eligible_date,
                    'year' => $year,
                    'earn_balance' => $leave->quantity,
                    'forwarded_balance' => $forwarded,
                    'total_balance' => (($leave->quantity + $forwarded) > 16) ? 16 : ($leave->quantity + $forwarded),
                    'is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0,
                ]);
            } else if($jobTenure == 0) {
                $this->employee->earnLeaves()->update([
                    'eligible_date' => $eligible_date,
                    'year' => $year,
                    'earn_balance' => 0,
                    'forwarded_balance' => 0,
                    'total_balance' => 0,
                    'is_usable' => 0,
                ]);
                $previousLeave = $this->employee->leaveBalances->where('year', $year)->where('leave_type_id', LeaveStatus::EARNED)->first();
                $previousLeave->total = 0;
                $previousLeave->remain = 0 - $previousLeave->used;
                $previousLeave->save();
            }
        } else {
            if ($jobTenure >= 1 && $jobTenure < 2) {
                $previousLeave = $this->employee->leaveBalances->where('year', $year-1)->where('leave_type_id', LeaveStatus::EARNED)->first();
                if($forwarded == null){
                    if($previousLeave){
                        $forwarded = $previousLeave->remain;
                    }else {
                        $forwarded = 0;
                    }
                }
                $earnBalance = round(($leave->quantity / 12) * (12 - (Carbon::parse($date)->format('m') - 1)));
                $totalBalance = round(($leave->quantity / 12) * (12 - (Carbon::parse($date)->format('m') - 1))) + $forwarded;
                $totalBalance = ($totalBalance > 16) ? 16 : $totalBalance;
    
                $this->employee->earnLeaves()->create([
                    'eligible_date' => $eligible_date,
                    'year' => $year,
                    'earn_balance' => $earnBalance,
                    'forwarded_balance' => $forwarded,
                    'total_balance' => $totalBalance,
                    'is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0,
                ]);
    
            } elseif($jobTenure > 2) {
                $this->employee->earnLeaves()->create([
                    'eligible_date' => $eligible_date,
                    'year' => $year,
                    'earn_balance' => $leave->quantity,
                    'forwarded_balance' => $forwarded,
                    'total_balance' => (($leave->quantity + $forwarded) > 16) ? 16 : ($leave->quantity + $forwarded),
                    'is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0,
                ]);
            } else if($jobTenure == 0) {
                $this->employee->earnLeaves()->create([
                    'eligible_date' => $eligible_date,
                    'year' => $year,
                    'earn_balance' => 0,
                    'forwarded_balance' => 0,
                    'total_balance' => 0,
                    'is_usable' => 0,
                ]);
            }
        }
    }

    public function calculateEarnLeaveBalance()
    {
        $today = Carbon::now()->format('Y-m-d');
        //$today = Carbon::create('2020-12-15')->format('Y-m-d');
        $startOfYear = Carbon::parse($today)->startOfYear()->format('Y-m-d');
        $doj = $eligible_date = $this->getEligibleDate();
        $earnLeaveAvailableTillNow = (((Carbon::parse($today)->diffInDays(max($startOfYear, $doj))) / 30.416666667) * ($this->earnLeave / 12));

        return round($earnLeaveAvailableTillNow);
    }


    public function earnLeaveWithForwarded()
    {
        // $earnForwardedLeave = $this->employee->earnLeaves()->where('year', $this->present_year)->where('is_usable', 1)->first()->forwarded_balance ?? 0;
        // return $this->calculateEarnLeaveBalance() + $earnForwardedLeave;

        $earnLeaveBalance = $this->employee->leaveBalances()
            ->where('year', $this->present_year)
            ->where('employment_type_id', $this->employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', LeaveStatus::EARNED)
            ->where('is_usable', 1)
            ->first();
        return ($earnLeaveBalance) ? $earnLeaveBalance->remain : 0;
    }


    public function earnLeaveRemain()
    {
        $earnLeaveBalance = $this->employee->leaveBalances()
            ->where('year', $this->present_year)
            ->where('employment_type_id', $this->employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', LeaveStatus::EARNED)
            // ->where('is_usable', 1)
            ->first();

        // dd($earnLeaveBalance);

        return ($earnLeaveBalance) ? $this->earnLeaveWithForwarded() - $earnLeaveBalance->used : 'Not eligible';
    }

    public function applyEarnLeave($quantity)
    {
        $from_forwarded_el = false;
        $can_apply = false;

        $earnLeaveBalance = $this->employee->leaveBalances()
            ->where('year', $this->present_year)
            ->where('employment_type_id', $this->employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', LeaveStatus::EARNED)
            ->where('is_usable', 1)
            ->first();
        if ($earnLeaveBalance->remain >= $quantity){
            $can_apply = true;
        }elseif($earnLeaveBalance && ($earnLeaveBalance->remain < $quantity)){
            $el_need = $quantity - $earnLeaveBalance->remain;
            $forwarded_balance = $this->employee->earnLeaves()->where('year', date('Y'))->where('is_usable', 1)->first();
            if ($forwarded_balance && ($forwarded_balance->forwarded_balance >= $el_need)){
                $from_forwarded_el = $el_need;
                $can_apply = true;
            }
        }
        return [
            'quantity' => $quantity,
            'from_forwarded_el' => $from_forwarded_el,
            'can_apply' => $can_apply
        ];
    }

    public function proratedCasualLeave()
    {
        $today = Carbon::now()->format('Y-m-d');
        $startOfYear = Carbon::parse($today)->startOfYear()->format('Y-m-d');
        $doj = $eligible_date = $this->getEligibleDate();
        if($this->employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PERMANENT) {
            $proratedCasualLeave = $this->casualLeave;
        } else {
            $proratedCasualLeave = (((Carbon::parse($today)->diffInDays(max($startOfYear, $doj))) / 30.416666667) * ($this->casualLeave / 12));   
        }        

        return round($proratedCasualLeave);
    }

    public function proratedCasualLeaveRemain()
    {         
        $casualLeaveBalance = $this->employee->leaveBalances()
            ->where('year', $this->present_year)
            ->where('employment_type_id', $this->employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', LeaveStatus::CASUAL)
            //->where('is_usable', 1)
            ->first();
        return ($casualLeaveBalance) ? $this->proratedCasualLeave() - $casualLeaveBalance->used : 'Not eligible';
    }

    public function proratedSickLeave()
    {
        $today = Carbon::now()->format('Y-m-d');
        $startOfYear = Carbon::parse($today)->startOfYear()->format('Y-m-d');
        $doj = $eligible_date = $this->getEligibleDate();
        if($this->employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PERMANENT) {
            $proratedSickLeave = $this->sickLeave;
        } else {
            $proratedSickLeave = (((Carbon::parse($today)->diffInDays(max($startOfYear, $doj))) / 30.416666667) * ($this->sickLeave / 12));
        }  
        return round($proratedSickLeave);
    }

    public function proratedSickLeaveRemain()
    {
        $sickLeaveBalance = $this->employee->leaveBalances()
            ->where('year', $this->present_year)
            ->where('employment_type_id', $this->employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', LeaveStatus::SICK)
            //->where('is_usable', 1)
            ->first();
            // print_r($this->employee->employer_id);
             
        if($this->employee->employer_id == 430){
            // dd($sickLeaveBalance);
            // dd($this->employee);
            // dd(\App\Utils\EmploymentTypeStatus::PERMANENT);
            // dd($this->proratedSickLeave());
        }        

        return ($sickLeaveBalance) ? ($this->proratedSickLeave() - $sickLeaveBalance->used) : 'Not eligible';
    }
}
