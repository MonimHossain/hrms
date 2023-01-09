<?php

namespace App\Http\Controllers\Admin\NoticeAndEvent;

use App\Center;
use App\Department;
use App\Division;
use App\Document;
use App\Employee;
use App\EmployeeDepartmentProcess;
use App\EventNotice;
use App\EventNoticeFilter;
use App\Jobs\NoticeEventMailSenderJob;
use App\Notifications\EventAndNoticeNotification;
use App\Process;
use App\ProcessSegment;
use App\Utils\NoticeAndEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;



class NoticeEventControllers extends Controller
{
    public function newNoticeEvent()
    {
        $active = 'new-event-notice';
        $divisions =   Division::all();
        $departments = Department::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $centers = Center::all();
        return view('admin.noticeAndEvent.new-event-notice', compact('active', 'departments', 'processes', 'processSegments', 'centers', 'divisions'));
    }

    public function saveNoticeEvent(Request $request)
    {

        $validator = $this->saveNoticeEventValidateRequest($request);

        if ($validator->fails()) {
            toastr()->success('Please Fill Up Required Fields');
            return redirect()
                ->route('admin.notice.board');
        }

        $eventNotice = new EventNotice();
        $eventNotice->target_employee = $request->targetEmployee;
        $eventNotice->title = $request->title;
        $eventNotice->content = $request->content_text;
        $eventNotice->is_event = ($request->has('is_event') == "on")? 1:0;
        $eventNotice->event_date = ($request->has('event_date') == "on")? $request->event_date:Carbon::now();
        $eventNotice->status = $request->status;
        $eventNotice->is_pinned = ($request->has('is_pinned') == "on")? 1:0;
        $eventNotice->is_mail = ($request->has('is_mail') == "on")? 1:0;
        $eventNotice->is_remainder = ($request->has('is_remainder') == "on")? 1:0;
        $eventNotice->created_by = 120;
        $eventNotice->banner = $request->hasFile('banner') ? $this->documentUpload($request, 'banner'):'no-image';
        $eventNotice->save();

        if($request->targetEmployee === '2'){
            foreach ($request->dps as $row){
                $eventNoticeFilter = new EventNoticeFilter();
                $eventNoticeFilter->division_id  = $row['division'] ?? 0;
                $eventNoticeFilter->center_id  = $row['center'] ?? 0;
                $eventNoticeFilter->department_id  = $row['department'] ?? 0;
                $eventNoticeFilter->process_id   = $row['process'] ?? 0;
                $eventNoticeFilter->process_segment_id   = $row['processSegment'] ?? 0;
                $eventNoticeFilter->event_notice_id    = $eventNotice->id;
                $eventNoticeFilter->save();
            }
        }

        if($request->has('is_mail')){
            $mailContent = $request->content_text;

            $query = EmployeeDepartmentProcess::query();
            $query->when($request->department, function ($q) use ($request) {
                return $q->where('department_id', '=', $request->department)->where('removed_at', '=', null);
            });

            $query->when($request->process, function ($q) use ($request) {
                return $q->where('process_id', '=', $request->process);
            });

            $query->when($request->processSegment, function ($q) use ($request) {
                return $q->where('process_segment_id', '=', $request->processSegment);
            });

            $userListForMail = $query->get();
            $this->sendMail($userListForMail, $mailContent);

            $this->sendNotification($query->get()->pluck('employee_id'));
        }

        toastr()->success('Event successfully saved');
        return redirect()->route('admin.notice.board');
    }

    // file upload
    public function documentUpload($request, $name)
    {
        $file = $request->file($name);
        $reName = uniqid() . '_' . trim($file->getClientOriginalName());
        $request->file($name)->storeAs('public/hrmsDocs/event/banners', $reName);
        return $reName;
    }


    public function loadProcessSegmentList(Request $request)
    {
        $id = $request->input('id');
        $documentName = ProcessSegment::where('process_id',$id)->get();
        return $documentName->pluck('name', 'id')->all();
    }

    public function noticeBoard()
    {
        $active = 'notice-board';
        $calendarDataset  =  (new \App\Http\Controllers\User\NoticeEventControllers)->getFilterDataForNoticeEvent()->filter(function ($item){
            return $item;
        })->sortByDesc('id');
        return view('admin.noticeAndEvent.notice-board', compact('active', 'calendarDataset'));
    }

    public function showNoticeEvent($id)
    {
        $active = 'notice-board';
        $calendarData = EventNotice::find($id);
        return view('admin.noticeAndEvent.show-notice-board', compact('active', 'calendarData'));
    }

    public function editNoticeEvent($id)
    {
        $active = 'notice-board';
        $editRow = EventNotice::find($id);
        $editRowFilter = EventNoticeFilter::where('event_notice_id',$id)->get();
        $departments = Department::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $centers = Center::all();
        $divisions = Division::all();

        return view('admin.noticeAndEvent.edit-event-notice', compact('active', 'departments', 'processes', 'processSegments', 'centers', 'editRow', 'editRowFilter', 'divisions'));
    }

    public function updateNoticeEvent(Request $request)
    {
//        dd($request->all());
        $eventNotice = EventNotice::find($request->id);
        $eventNotice->target_employee = $request->targetEmployee;
        $eventNotice->title = $request->title;
        $eventNotice->content = $request->content_text;
        $eventNotice->is_event = ($request->has('is_event') == "on")? 1:0;
        $eventNotice->event_date = ($request->has('event_date') == "on")? $request->event_date:Carbon::now();
        $eventNotice->status = $request->status;
        $eventNotice->is_pinned = ($request->has('is_pinned') == "on")? 1:0;
        $eventNotice->is_mail = ($request->has('is_mail') == "on")? 1:0;
        $eventNotice->is_remainder = ($request->has('is_remainder') == "on")? 1:0;
        $eventNotice->created_by = auth()->user()->employee_id;
        $eventNotice->banner = $request->hasFile('banner') ? $this->documentUpload($request, 'banner'):$request->banner_hidden;
        $eventNotice->save();


        if($request->targetEmployee === '2'){
            EventNoticeFilter::where('event_notice_id',$request->id)->delete();
            foreach ($request->dps as $row){
                $eventNoticeFilter = new EventNoticeFilter();
                $eventNoticeFilter->division_id  = $row['division'] ?? 0;
                $eventNoticeFilter->center_id  = $row['center'] ?? 0;
                $eventNoticeFilter->department_id  = $row['department'] ?? 0;
                $eventNoticeFilter->process_id   = $row['process'] ?? 0;
                $eventNoticeFilter->process_segment_id   = $row['processSegment'] ?? 0;
                $eventNoticeFilter->event_notice_id    = $eventNotice->id;
                $eventNoticeFilter->save();
            }
        }else{
            EventNoticeFilter::where('event_notice_id',$request->id)->delete();
        }


        if($request->has('is_mail')){
            $mailContent = $request->content_text;

            $query = EmployeeDepartmentProcess::query();
            $query->when($request->department, function ($q) use ($request) {
                return $q->where('department_id', '=', $request->department)->where('removed_at', '=', null);
            });

            $query->when($request->process, function ($q) use ($request) {
                return $q->where('process_id', '=', $request->process);
            });

            $query->when($request->processSegment, function ($q) use ($request) {
                return $q->where('process_segment_id', '=', $request->processSegment);
            });

            $userListForMail = $query->get();
            $this->sendMail($userListForMail, $mailContent);

            $this->sendNotification($query->get()->pluck('employee_id'));

        }

        toastr()->success('Event successfully saved');
        return redirect()->route('admin.notice.board');
    }

    public function sendNotification($users)
    {
        foreach ($users as $user){
            $employee = Employee::find($user);
            Notification::send($employee->userDetails, new EventAndNoticeNotification($employee->FullName, 'Notice and Event', 'employee.notice.board'));
        }
    }

    public function eventCalender()
    {
        $active = 'event-calender';
        $calendarDataset = (new \App\Http\Controllers\User\NoticeEventControllers)->getFilterDataForNoticeEvent()->filter(function ($item){
            return $item;
        });
        return view('admin.noticeAndEvent.event-calender', compact('active', 'calendarDataset'));

    }

    public function findPriority($item, $key)
    {
        echo "$key holds $item\n";
    }

    public function sendMail($users, $data)
    {
        foreach ($users as $user){
            dispatch(new NoticeEventMailSenderJob($user->employee->userDetails->email, $data));
        }
    }

    protected function saveNoticeEventValidateRequest($request)
    {
      return tap(Validator::make($request->all(), [
          'title' => 'required|max:255',
          'content_text' => 'required',
      ]), function (){
          if(request()->hasFile('banner')){
            request()->validate([
                'banner' => 'file|image|max:5000'
            ]);
          }
      });
    }

}
