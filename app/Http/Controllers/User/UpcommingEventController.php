<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Holiday;
use Carbon\Carbon;
use App\Utils\NoticeAndEvent;

class UpcommingEventController extends Controller
{


    public function index(Request $request)
    {
        $active = 'upcomming-events';
        $currentMonth = Carbon::parse(Carbon::now())->format('m');
        $nextMonth = Carbon::parse(Carbon::now()->addMonths(1))->format('m');
        $birthdayData = Employee::with(['employeeJourney','teamMember', 'employeeJourney.designation', 'userDetails.employeeDetails'])->whereMonth('date_of_birth', '=', $currentMonth)->orderByRaw('DATE_FORMAT(date_of_birth, "%m-%d")')->whereHas('employeeJourney', function($q) use ($request){
            $q->where('employee_status_id', 1);
        })->get();
        
        $anniversary = Employee::with('employeeJourney')->whereHas('employeeJourney', function($q) use($nextMonth, $currentMonth){
            $q->whereMonth('doj', '=', $currentMonth)->where('employee_status_id', 1)->with(['employeeJourney']);
        })->get();

        $sorted_anniversary = $anniversary->sortBy(function($item){            
            if($item->employeeJourney) {
                return date('d', strtotime($item->employeeJourney->doj));
            }
        })->values();

        $anniversary = $sorted_anniversary;

        $calendarDataset =  (new NoticeEventControllers)->getUpcomingFilterDataForNoticeEvent()->filter(function ($item){
            return $item->status === NoticeAndEvent::SHOWSTATUS['PUBLISH'];
        })->sortByDesc('id');
        
        $employee = Employee::find(auth()->user()->employee_id);
        $religion = 'Islam';
        if($employee->religion){
            $religion = $employee->religion;
        }
        $holidays = Holiday::whereJsonContains('religion->religion', [$religion])->whereYear('end_date', '=', date('Y'))->orderBy('start_date', 'asc')->get();

        return view('user.upcomming.index',compact('active', 'birthdayData', 'anniversary', 'calendarDataset', 'calendarDataset', 'holidays')
        );
    }
}
