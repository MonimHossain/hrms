<?php

namespace App\Services;

use App\Employee;
use App\Holiday;
use App\LeaveBalance;
use App\LeaveBalanceSetting;
use App\LeaveType;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Request;

class LeaveService
{
    private $employee, $request, $isBridge = false, $redirectBack = false;
    private $holidays=[];

    public function __construct($employee, $request = null)
    {
        $this->employee = $employee;
        $this->request = $request;
    }

    public function getEligibleDate()
    {
        return (($this->employee->employeeJourney) && ($this->employee->employeeJourney->probation_start_date)) ? $this->employee->employeeJourney->probation_start_date :
            ((($this->employee->employeeJourney) && ($this->employee->employeeJourney->permanent_doj)) ? $this->employee->employeeJourney->permanent_doj : null);
    }

    public function checkLeaveIsUsable($quantity){
        $request = $this->request;
        $employee = $this->employee;
        //$startDate = Carbon::create($request->input('start_date'));
        //$endDate = Carbon::create($request->input('end_date'));
        //$quantity = ($request->input('half_day')) ? 0.5 : $this->leaveCheck($startDate, $endDate)['count'];
        $eligible_date = ($this->employee->employeeJourney && ($this->employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT || $this->employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PROBATION)) ? $this->getEligibleDate() : true;

        $leaveBalanceActive = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', $request->input('leave_type_id'))
            ->where('is_usable', 1)
            ->exists();
        if($leaveBalanceActive){
            return false;
        }

        $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->where('employment_type_id', $employee->employeeJourney->employment_type_id)
            ->where('leave_type_id', $request->input('leave_type_id'))
            ->where('is_usable', 0)
            ->first();

        //dd($eligible_date);

        if(!$eligible_date){
            toastr()->error('Your probation/confirmation date is missing. Please contact with HR.');
            return true;
        }elseif($request->input('leave_type_id') == LeaveStatus::EARNED && $leaveBalance){
            if(Carbon::parse($eligible_date)->diffInMonths(Carbon::now()) > 12){
                $leaveBalance->is_usable = 1;
                $leaveBalance->save();
                return false;
            }else{
                toastr()->error('You are not eligible for this leave.');
                return true;
            }
        }elseif(($request->input('leave_type_id') == LeaveStatus::MATERNITY || $request->input('leave_type_id') == LeaveStatus::PATERNITY) && $leaveBalance){
            if(Carbon::parse($eligible_date)->diffInMonths(Carbon::now()) > 6){
                $leaveBalance->is_usable = 1;
                $leaveBalance->save();
                return false;
            }else{
                toastr()->error('You are not eligible for this leave.');
                return true;
            }
        }elseif($leaveBalance){
            $leaveBalance->is_usable = 1;
            $leaveBalance->save();
            return false;
        }else{
            return false;
        }

    }

    public function leaveBalanceCalculate($amount, $probationdate = null, $permanentdate = null)
    {
        $today = Carbon::now()->format('Y-m-d');
        $startOfYear = Carbon::parse($today)->startOfYear()->format('Y-m-d');
        if($probationdate ){
            $doj = $eligible_date = $probationdate;
        }elseif(($probationdate == null) && $permanentdate){
            $doj = $eligible_date = $permanentdate;
        }else{
            $doj = $eligible_date = $this->getEligibleDate();
        }
        $date = Carbon::parse($startOfYear);
        $now = Carbon::parse($doj);
        $diff = $date->diffInDays($now);
        $eligible_amount = $diff * ($amount / 365);
        return ($doj < $startOfYear) ? $amount : $amount - round($eligible_amount);
    }


    // leave balance generate
    public function leaveBalanceGenerate($employeeType, $probationdate, $permanentdate, $alGenerate = false)
    {
        // dd('dasd');
        // dd($alGenerate);
        $this->request = request();
        ($this->request !=null && $this->request->has('year')) ?: $this->request->request->add(['year' => date('Y')]);
        
        if ($this->employee->leaveBalances->where('year', $this->request->input('year'))->where('employment_type_id', $employeeType)->count()) {
            toastr()->error('Leave balance is already exists for '.$this->request->input('year').'!');
            return false;
        }
        //$existingLeave = $this->employee->leaveBalances()->where('year', $this->request->input('year') - 1)->get();
        $leaves = LeaveBalanceSetting::where('employment_type_id', $employeeType)->get();
        $previousLeaveBalances = $this->employee->leaveBalances->where('year', date('Y', strtotime($this->request->input('year'))));        

        $leaveTypes = LeaveType::all();
        foreach ($leaves as $key => $leave) {
            if ($this->employee->gender == 'Male' && $leave->leave_type_id == $leaveTypes->where('short_code', 'ML')->first()->id) {
                continue;
            }
            if ($this->employee->gender == 'Female' && $leave->leave_type_id == $leaveTypes->where('short_code', 'PL')->first()->id) {
                continue;
            }
            if (LeaveStatus::EARNED != $leave->leaveType->id) {
                //$leaveExist = $existingLeave->where('year', date("Y"))->where('leave_type_id', $leave->leaveType->id)->first();

                $leave_quantity = ((LeaveStatus::PATERNITY == $leave->leave_type_id || LeaveStatus::MATERNITY == $leave->leave_type_id) ? $leave->quantity : $this->leaveBalanceCalculate($leave->quantity));
                $previousLeaveBalance = $previousLeaveBalances->where('leave_type_id', $leave->leaveType->id)->first();

                $leaveBalance = new LeaveBalance();
                $leaveBalance->employee_id = $this->employee->id;
                //$leaveBalance->year = date("Y");
                $leaveBalance->year = $this->request->input('year');
                $leaveBalance->probation_start_date = $probationdate;
                $leaveBalance->permanent_doj = $permanentdate;
                $leaveBalance->employment_type_id = $employeeType;
                $leaveBalance->leave_type_id = $leave->leaveType->id;
                //$leaveBalance->total = ($leaveExist) ? $leaveExist->total : $leave_quantity;
                //$leaveBalance->used = ($leaveExist) ? $leaveExist->total - $leaveExist->remain : 0;
                //$leaveBalance->remain = ($leaveExist) ? $leaveExist->remain : $leave_quantity;
                $leaveBalance->total = $leave_quantity;
                $leaveBalance->used = (isset($previousLeaveBalance) && $previousLeaveBalance->used) ? $previousLeaveBalance->used : 0;
                $leaveBalance->remain = (isset($previousLeaveBalance) && $previousLeaveBalance->used) ? $leave_quantity - $previousLeaveBalance->used : $leave_quantity;
                $leaveBalance->save();
            }

        }

        //annual leave balance generate
        // if ($alGenerate == true && (EmploymentTypeStatus::PERMANENT == $employeeType || EmploymentTypeStatus::PROBATION == $employeeType)) {
        if ($alGenerate == true && EmploymentTypeStatus::PERMANENT == $employeeType) {
            if (!$this->employee->earnLeaves()->where('year', date('Y', strtotime($this->request->input('year'))))->exists()){
                foreach ($leaves as $key => $leave) {
                    if (LeaveStatus::EARNED == $leave->leaveType->id) {
                        $earnLeaveService = new EarnLeaveService($this->employee);
                        (session()->has('earned_used')) ?
                        //$earnLeaveService->generateEarnBalance($leave, session('earned_used')) :
                        //$earnLeaveService->generateEarnBalance($leave);
                        $earnLeaveService->generateEarnBalanceYearly($leave, $this->request->input('year'), session('earned_used')) :
                        $earnLeaveService->generateEarnBalanceYearly($leave, $this->request->input('year'));

                    }
                }
            }
        }        
        toastr()->success('Leave Balance generated for new employment type.');
    }

    // leave balance re-generate
    public function leaveBalanceReGenerate($employeeType, $probationdate, $permanentdate, $alGenerate = false){
        ($this->request !=null && $this->request->has('year')) ?: $this->request->request->add(['year' => date('Y')]);

        if($probationdate){
            $this->employee->leaveBalances()->where('year', date('Y'))->update(['probation_start_date' => $probationdate]);
        }
        if($permanentdate){
            $this->employee->leaveBalances()->where('year', date('Y'))->update(['permanent_doj' => $permanentdate]);
        }
        if($probationdate || (($probationdate == null) && $permanentdate)){
            $leaves = LeaveBalanceSetting::where('employment_type_id', $employeeType)->get();
            $leaveTypes = LeaveType::all();
            foreach ($leaves as $key => $leave) {

                if (LeaveStatus::EARNED != $leave->leave_type_id) {
                    if ($this->employee->gender == 'Male' && $leave->leave_type_id == $leaveTypes->where('short_code', 'ML')->first()->id) {
                        continue;
                    }
                    if ($this->employee->gender == 'Female' && $leave->leave_type_id == $leaveTypes->where('short_code', 'PL')->first()->id) {
                        continue;
                    }
                    $leave_quantity = ((LeaveStatus::PATERNITY == $leave->leave_type_id || LeaveStatus::MATERNITY == $leave->leave_type_id) ? $leave->quantity : $this->leaveBalanceCalculate($leave->quantity, $probationdate, $permanentdate));
                    $leaveBalance = $this->employee->leaveBalances()->where('leave_type_id', $leave->leave_type_id)->where('employment_type_id', $employeeType)->where('year', date('Y'))->first();
                    $leaveBalance_id = $leaveBalance->id; 
                    if($this->employee->leaveBalances()->where('leave_type_id', $leave->leave_type_id)->where('employment_type_id', $employeeType)->where('year', date('Y'))->count() > 0) {
                        $this->employee->leaveBalances()->where('leave_type_id', $leave->leave_type_id)->where('employment_type_id', $employeeType)->where('year', date('Y'))->where('id', '!=' , $leaveBalance_id)->delete();
                    }
                    if($leaveBalance){
                        $leaveBalance->employee_id = $this->employee->id;
                        $leaveBalance->year = date("Y");
                        $leaveBalance->probation_start_date = $probationdate;
                        $leaveBalance->permanent_doj = $permanentdate;
                        $leaveBalance->employment_type_id = $employeeType;
                        $leaveBalance->leave_type_id = $leave->leaveType->id;
                        $leaveBalance->total = $leave_quantity;
                        $leaveBalance->remain = $leave_quantity - $leaveBalance->used;
                        $leaveBalance->save();
                    } else {
                        $leaveBalance = new LeaveBalance();
                        $leaveBalance->employee_id = $this->employee->id;
                        $leaveBalance->year = $this->request->input('year');
                        $leaveBalance->probation_start_date = $probationdate;
                        $leaveBalance->permanent_doj = $permanentdate;
                        $leaveBalance->employment_type_id = $employeeType;
                        $leaveBalance->leave_type_id = $leave->leaveType->id;
                        $leaveBalance->total = $leave_quantity;
                        $leaveBalance->used = 0;
                        $leaveBalance->remain = $leave_quantity;
                        $leaveBalance->save();
                    }
                } else if (LeaveStatus::EARNED == $leave->leave_type_id) {
                    if (!$this->employee->earnLeaves()->where('year', date('Y'))->exists() || true){
                        foreach ($leaves as $key => $leave) {
                            if (LeaveStatus::EARNED == $leave->leaveType->id) {
                                $earnLeaveService = new EarnLeaveService($this->employee);
                                (session()->has('earned_used')) ?
                                $earnLeaveService->generateEarnBalanceYearly($leave, $this->request->input('year'), session('earned_used')) :
                                $earnLeaveService->generateEarnBalanceYearly($leave, $this->request->input('year'));
        
                            }
                        }
                    }
                }
            }
            toastr()->success('Leave Balance updated');
        }
    }

    public function appliedLeaveCheck($startDate, $endDate)
    {
        $appliedLeaves = $this->employee->leaves()->where('start_date', '<=', $startDate)->where('end_date', '>=', $endDate)->get();
        if ($appliedLeaves->count()){
            return true;
        }
        return false;
    }

    public function holidayCheck($start_date, $end_date)
    {
        // bridge check
        $this->isBridge = $this->bridgeCheck($start_date, $end_date);
        $days = [];
        //dd($this->isBridge);
        if(!$this->isBridge){
            $holidays = Holiday::where(function($q) use ($start_date){
                    $q->whereJsonContains('religion->religion', [$this->employee->religion])
                        ->whereHas('centers', function ($q) {
                            $q->where('center_id', $this->employee->divisionCenters->where('is_main', 1)->first()->center_id);
                        })->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
                })
                ->orWhere(function($q) use ($end_date){
                    $q->whereJsonContains('religion->religion', [$this->employee->religion])
                        ->whereHas('centers', function ($q) {
                            $q->where('center_id', $this->employee->divisionCenters->where('is_main', 1)->first()->center_id);
                        })->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
                })
                ->get();

            $holidaysInMiddle = Holiday::whereJsonContains('religion->religion', [$this->employee->religion])
                ->whereHas('centers', function ($q) {
                    $q->where('center_id', $this->employee->divisionCenters->where('is_main', 1)->first()->center_id);
                })->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date)
                ->get();

            // bridge check
            //$this->isBridge = $this->bridgeCheck($start_date, $end_date);
            //dd($this->isBridge);
            foreach ($holidays as $holiday){
                $begin = new \DateTime($holiday->start_date);
                $end = new \DateTime($holiday->end_date);

                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $days[] = $i->format("Y-m-d");
                }
            }
            foreach ($holidaysInMiddle as $holiday){
                $begin = new \DateTime($holiday->start_date);
                $end = new \DateTime($holiday->end_date);

                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $days[] = $i->format("Y-m-d");
                }
            }
            $offDays = $this->offDayCheck($start_date, $end_date);
            $days = array_unique (array_merge($days, $offDays));
            //dd($offDays);
        }
        return $days;
    }

    public function bridgeCheck($start_date, $end_date){
        $request = $this->request;
        $employee = $this->employee;
        $isBridge = false;


        // check if bridge
        if($request->input('leave_type_id') == LeaveStatus::MATERNITY || $request->input('leave_type_id') == LeaveStatus::PATERNITY){
            $isBridge = true;
        }elseif($request->input('leave_type_id') != LeaveStatus::SICK){
            $start_next_date = Carbon::create($request->input('start_date'))->addDays(1);
            $end_prev_date = Carbon::create($request->input('end_date'))->subDays(1);
            $leave_in_middle_start = Carbon::create($request->input('start_date'))->subDays(1);
            $leave_in_middle_end = Carbon::create($request->input('start_date'))->addDays(1);

            //$checkStartEnd = Holiday::where('start_date', $start_next_date)->where('end_date', $end_prev_date)->first();
            $checkStartEnd = Holiday::whereJsonContains('religion->religion', [$employee->religion])
                ->whereHas('centers', function ($q) use ($employee){
                    $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
                })
                ->where('start_date', '<=', $start_next_date)->where('end_date', '>=', $end_prev_date)
                ->where('end_date', '!=', $end_date)
                ->first();
            $check = Holiday::whereJsonContains('religion->religion', [$employee->religion])
                ->whereHas('centers', function ($q) use ($employee){
                    $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
                })
                ->where('end_date', $end_date)
                ->first();



            //dd($check);
            //$checkInMiddle = Holiday::where('start_date', $leave_in_middle_end)->orWhere('end_date', $leave_in_middle_start)->get();
            $checkInMiddle = Holiday::where(function($q) use ($leave_in_middle_start, $leave_in_middle_end, $employee){
                $q->whereJsonContains('religion->religion', [$employee->religion])
                        ->whereHas('centers', function ($q) use ($employee){
                            $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
                        })
                        ->where('start_date', $leave_in_middle_end);
                })
                ->orWhere(function($q) use ($leave_in_middle_start, $leave_in_middle_end, $employee){
                    $q->whereJsonContains('religion->religion', [$employee->religion])
                        ->whereHas('centers', function ($q) use ($employee) {
                            $q->where('center_id', $employee->divisionCenters->where('is_main', 1)->first()->center_id);
                        })->where('end_date', $leave_in_middle_start);
                })
                ->get();

            //dd($isBridge);
            //
            $period = CarbonPeriod::create($start_date, $end_date);
            $day_off_start = $employee->fixedOfficeTime->where('is_offday', 1)->where('day', Carbon::parse($end_date)->format('l'));
            $checkOffDay = [];
            foreach ($period as $date) {
                if($employee->fixedOfficeTime->count()){
                    $day_offs = $employee->fixedOfficeTime->where('is_offday', 1)->where('day', $date->format('l'));
                    if(!is_null($day_offs->first())) { $checkOffDay[] = $day_offs->first();}
                }
            }



            if($checkStartEnd && !$check){
                toastr()->warning('You have holiday in between your start and end date. This will considered as a bridge.');
                $isBridge = true;
            }elseif($checkInMiddle->count()){
                if($checkInMiddle->count() > 2){
                    if($request->input('leave_type_id') == LeaveStatus::CASUAL){
                        toastr()->error('You can not apply for CL for this day. This will be a bridge otherwise.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                        //return redirect()->back()->withInput();
                        return $this->redirectBack = true;
                    }
                    //if($checkInMiddle[0]){
                    //    $startDate = Carbon::create($checkInMiddle[0]['start_date']);
                    //}
                    //if($checkInMiddle[1]){
                    //    $endDate = Carbon::create($checkInMiddle[1]['end_date']);
                    //}
                    $isBridge = true;
                }
            }
            elseif(!$day_off_start->count() && count($checkOffDay) ){
                $isBridge = true;

            }
            //dd($isBridge);
        }
        //dd(!$day_off_start->count() && count($checkOffDay));
        return $isBridge;
    }

    public function offDayCheck($start_date, $end_date){
        $request = $this->request;
        $employee = $this->employee;
        $period = CarbonPeriod::create($start_date, $end_date);
        $days = [];
        // checking dayoff
        // Iterate over the period
        foreach ($period as $date) {
            if($employee->fixedOfficeTime->count()){
                $day_offs = $employee->fixedOfficeTime->where('is_offday', 1)->where('day', $date->format('l'));
                //dump($day_offs);
                if($day_offs->count()){
                    $days[] = $date->format('Y-m-d');
                }
            }
        }
        return $days;
    }

    public function skipHolidaysFromLeave($start_date, $end_date, $isBridge = null)
    {

        //if($isBridge == false){
        //    // get holidays
        //    $holidays = $this->holidayCheck($start_date, $end_date);
        //} else {
        //    $holidays = [];
        //}
        $this->holidays = $holidays = $this->holidayCheck($start_date, $end_date);
        //dd($this->holidays);

        // create leaves date array
        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $leaveDays = [];
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $leaveDays[] = $i->format("Y-m-d");
        }

        //dd($leaveDays == $holidays);
        if(count($holidays) == 1 && (count($leaveDays) == 1 ) && ($leaveDays == $holidays)){
            toastr()->error("You're applying leave on holiday", "Opss!");
            $this->redirectBack = true;
            return [
                'count' => null,
                'days'  => null,
                'redirectBack' => $this->redirectBack
            ];
        }

        return array_diff($leaveDays, $holidays);

    }

    public function leaveCheck($start_date, $end_date)
    {
        if($this->request->input('leave_type_id') == LeaveStatus::CASUAL && (Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date))+1) >2){
            toastr()->warning("CL is not allowed more than 2 consecutive days. Please apply for AL", "Note!");
            $this->redirectBack = true;
            return [
                'count' => null,
                'days'  => null,
                'redirectBack' => $this->redirectBack
            ];
        }else{
            $leaveDate = $this->skipHolidaysFromLeave($start_date, $end_date);

            return [
                'count' => count($leaveDate),
                'days'  => $leaveDate,
                'redirectBack' => $this->redirectBack
            ];
        }
        //return [
        //    'count' => count($leaveDate),
        //    'days'  => $leaveDate,
        //    'redirectBack' => $this->redirectBack
        //];
    }
}
