<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use Carbon\Carbon;

class ExpiredController extends Controller
{


    public function expiredContractual()
    {
        $active = 'expired-contractual';
        $currentMonth = Carbon::parse(Carbon::now())->format('Y-m-d');
        $nextMonth = Carbon::parse(Carbon::now()->addMonths(1))->format('Y-m-d');
        $contractuals = Employee::with('employeeJourney')->whereHas('employeeJourney', function($q) use($nextMonth, $currentMonth){
            //$q->whereMonth('contract_end_date', '<=', $nextMonth)->whereMonth('contract_end_date', '>=', $currentMonth)->with(['employeeJourney']);
            $q->whereBetween('contract_end_date', [$currentMonth, $nextMonth]);
        })->with(['employeeJourney'])->get();
        return view('admin.upcomming.contractual', compact('active', 'contractuals'));

    }


    public function expiredProbation()
    {
        /* $probations = Employee::with('employeeJourney')->whereHas('employeeJourney', function($q) use($nextMonth, $currentMonth){
            $q->whereMonth('probation_start_date', '<=', $nextMonth)->whereMonth('probation_start_date', '>=', $currentMonth)->with(['employeeJourney']);
        })->get(); */

        $active = 'expired-probation';

        $currentMonth = now()->format('Y-m-d');
        $nextMonth = Carbon::now()->addMonths(1)->format('Y-m-d');
        $probations = Employee::with('employeeJourney')->whereHas('employeeJourney', function($q){
            $q->whereNotNull('probation_period');
        })->with(['employeeJourney'])->get();


        $employeeList = [];
        foreach($probations as $probation)
        {
            $probation_end = Carbon::parse($probation->employeeJourney->probation_start_date)->addMonths($probation->employeeJourney->probation_period)->format('Y-m-d');
              if(($currentMonth <= $probation_end) && ($probation_end <= $nextMonth)){
                $employeeList[] = $probation;
             }
        }

       // dd($employeeList);


        return view('admin.upcomming.probation', compact('active', 'employeeList'));
    }


}
