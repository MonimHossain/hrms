<?php

namespace App\Http\Controllers\User;

use App\Center;
use App\Division;
use App\Employee;
use App\EmployeeDepartmentProcess;
use App\EventNotice;
use App\EventNoticeFilter;
use App\Utils\NoticeAndEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NoticeEventControllers extends Controller
{

    public function removeElement($array,$value) {
        if (($key = array_search($value, $array)) !== false) {
            unset($array[$key]);
        }
        return $array;
    }

    public function noticeBoard()
    {
        $active = 'user-notice-board';
        $calendarDataset = $this->getFilterDataForNoticeEvent()->where('status', NoticeAndEvent::SHOWSTATUS['PUBLISH']);
        return view('user.noticeAndEvent.notice-board', compact('active', 'calendarDataset'));
    }


    public function eventCalender()
    {
        $active = 'user-event-calender';
        $calendarDataset = $this->getFilterDataForNoticeEvent();
        return view('admin.noticeAndEvent.event-calender', compact('active', 'calendarDataset'));
    }



    public function getFilterDataForNoticeEvent()
    {
        $user_id = auth()->user()->employee_id;
        $division = Division::where('name', session()->get('division'))->first()->id ?? 0;
        $center = Center::where('center', session()->get('center'))->first()->id ?? 0;
        $department = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];

        $expOne = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division){
            $q->where('division_id', $division);
            $q->whereIn('center_id', [0]);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expTwo = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expThree = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expFour = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expFive = EventNotice::whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process, $processSegment){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', $processSegment);
        })->get();

        $expSix = EventNotice::doesnthave('eventNoticeFilter')->get();

        return collect($expOne)->merge($expTwo)->merge($expThree)->merge($expFour)->merge($expFive)->merge($expSix)->sortByDesc('id');
    }
    
    public function getUpcomingFilterDataForNoticeEvent()
    {
        $user_id = auth()->user()->employee_id;
        $division = Division::where('name', session()->get('division'))->first()->id ?? 0;
        $center = Center::where('center', session()->get('center'))->first()->id ?? 0;
        $department = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];

        $expOne = EventNotice::whereYear('event_date', date('Y'))->whereMonth('event_date', date('m'))->orderByRaw('DATE_FORMAT(event_date, "%m-%d")')->whereHas('eventNoticeFilter', function($q) use ($division){
            $q->where('division_id', $division);
            $q->whereIn('center_id', [0]);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expTwo = EventNotice::whereYear('event_date', date('Y'))->whereMonth('event_date', date('m'))->orderByRaw('DATE_FORMAT(event_date, "%m-%d")')->whereHas('eventNoticeFilter', function($q) use ($division,$center){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expThree = EventNotice::whereYear('event_date', date('Y'))->whereMonth('event_date', date('m'))->orderByRaw('DATE_FORMAT(event_date, "%m-%d")')->whereHas('eventNoticeFilter', function($q) use ($division,$center, $department){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expFour = EventNotice::whereYear('event_date', date('Y'))->whereMonth('event_date', date('m'))->orderByRaw('DATE_FORMAT(event_date, "%m-%d")')->whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expFive = EventNotice::whereYear('event_date', date('Y'))->whereMonth('event_date', date('m'))->orderByRaw('DATE_FORMAT(event_date, "%m-%d")')->whereHas('eventNoticeFilter', function($q) use ($division,$center, $department, $process, $processSegment){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', $processSegment);
        })->get();

        $expSix = EventNotice::whereYear('event_date', date('Y'))->whereMonth('event_date', date('m'))->orderByRaw('DATE_FORMAT(event_date, "%m-%d")')->doesnthave('eventNoticeFilter')->get();

        return collect($expOne)->merge($expTwo)->merge($expThree)->merge($expFour)->merge($expFive)->merge($expSix);
    }



    public function showNoticeEventUser($id)
    {
        $active = 'notice-board';
        $calendarData = EventNotice::find($id);
        return view('user.noticeAndEvent.show-notice-board', compact('active', 'calendarData'));
    }
}
