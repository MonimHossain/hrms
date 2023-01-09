<?php

namespace App\Console\Commands;

use App\Employee;
use App\Scopes\DivisionCenterScope;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AnnualLeaveGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'al:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New Annual Leave Generate.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $employees = Employee::whereHas('employeeJourney', function($q){
            $q->where(function ($q){
                $q->where('probation_start_date', '<=', Carbon::now()->subYear(1)->format('Y-m-d'))
                    ->orWhere('permanent_doj', '<=', Carbon::now()->subYear(1)->format('Y-m-d'));
            })
            ->where(function ($q){
                $q->where('employment_type_id', EmploymentTypeStatus::PROBATION)
                    ->orWhere('employment_type_id', EmploymentTypeStatus::PERMANENT);
            });
        })
        ->withoutGlobalScope(DivisionCenterScope::class)
        ->with(['employeeJourney', 'leaveBalances', 'earnLeaves'])
        ->get();

        foreach ($employees as $employee){
            $annualLeave = $employee->leaveBalances->where('leave_type_id', LeaveStatus::EARNED)->where('year', date("Y"));
            $eligible_date = $this->getEligibleDate($employee);
            $present_year = Carbon::now()->format('Y');
            $jobTenure = $this->getJobTenure($employee, $present_year);
            //dd($jobTenure);
            if(!$annualLeave->count() && $jobTenure >= 1 && $jobTenure < 2){
                $employee->earnLeaves()->create([
                    'eligible_date' => $eligible_date,
                    'year' => $present_year,
                    'earn_balance' => 16,
                    'forwarded_balance' => 0,
                    'total_balance' => 16,
                    'is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0,
                ]);
            }elseif($annualLeave->count()){
                $al = $employee->leaveBalances->where('leave_type_id', LeaveStatus::EARNED)->where('year', date("Y"))->first();
                if($al){
                    $al->update(['is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0]);
                }
            }
        }
    }

    public function getEligibleDate($employee)
    {
        return (($employee->employeeJourney) && ($employee->employeeJourney->probation_start_date)) ? $employee->employeeJourney->probation_start_date :
            ((($employee->employeeJourney) && ($employee->employeeJourney->permanent_doj)) ? $employee->employeeJourney->permanent_doj : null);
    }

    public function getJobTenure($employee, $year){
        return ($employee->employeeJourney->probation_start_date) ? Carbon::parse($employee->employeeJourney->probation_start_date)->diffInYears(now()->format('Y-m-d')) :
            (($employee->employeeJourney->permanent_doj) ? Carbon::parse($employee->employeeJourney->permanent_doj)->diffInYears(now()->format('Y-m-d')) : null);
    }
}
