<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;
use Validator;
use App\Roster;
use Carbon\Carbon;
use App\RosterRequest;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\Employee;
use App\Notifications\RosterRequest as AppRosterRequest;
use App\Attendance;
use App\Utils\AttendanceStatus;

class RosterController extends Controller
{

    use Notifiable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createView(){
        $active = 'create-roster';
        $rosters = Roster::all();
        return view('user.roster.create-roster', compact('active', 'rosters'));
    }


    public function createSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'roster_id' => 'required',
            'off_days' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Please fill all fields.');
            return redirect()->back();
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        // set weekend
        Carbon::setWeekendDays($request->input('off_days'));
        while(strtotime($start_date) <= strtotime($end_date)){
            // $rosterRequests = new RosterRequest();
            // $rosterRequests->employee_id = Auth::user()->employee_id;
            // $rosterRequests->date = $start_date;

            $rosterRequests = RosterRequest::firstOrNew(['employee_id' => Auth::user()->employee_id, 'date' => $start_date]);

            if(Carbon::create($start_date)->isWeekend()){
                $rosterRequests->roster_id = null;
                $rosterRequests->is_offday = 1;
            }else{
                $rosterRequests->roster_id = $request->input('roster_id');
            }

            // $rosterRequests->off_days = serialize($request->input('off_days'));

            $rosterRequests->save();
            $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
        }

        toastr()->success('Your roster generated successfully. Please revised and submit for approval.');

        return redirect()->route('user.roster.revise.view');

    }


    public function reviseView(Request $request){
        $active = 'revise-roster';
        $rosters = Roster::all();
        // $rosterRequests = RosterRequest::where('employee_id', Auth::user()->employee_id)->where('date', '>', Carbon::now()->toDateString())->where('is_revised', 0)->get();
        //$rosterRequests = RosterRequest::where('employee_id', Auth::user()->employee_id)->where('date', '>', Carbon::now()->toDateString())->get();
        //$rosterRequests = Attendance::where('employee_id', Auth::user()->employee_id)->whereMonth('date', Carbon::now()->month)->get();
        $month = ($request->get('month')) ? $request->get('month') : Carbon::now()->month;
        $year = ($request->get('year')) ? $request->get('year') : Carbon::now()->year;
        $rosterRequests = Attendance::where('employee_id', Auth::user()->employee_id)
                                    ->when($month, function ($q) use ($month){
                                        $q->whereMonth('date', $month);
                                    })
                                    ->when(!$month, function ($q) use ($month){
                                        $q->whereMonth('date', Carbon::now()->month);
                                    })
                                    ->when($year, function ($q) use ($year){
                                        $q->whereYear('date', $year);
                                    })
                                    ->when(!$year, function ($q) use ($year){
                                        $q->whereYear('date', Carbon::now()->year);
                                    })
                                    ->get();
        //dd($rosterRequests);
        return view('user.roster.revise-roster', compact('active', 'month', 'year', 'rosters', 'rosterRequests'));
    }


    public function reviseChangeRoster(Request $request){
        // dd($request);
        $rosterRequest = RosterRequest::findOrFail($request->input('id'));

        if($request->input('is_offday')){
            $rosterRequest->roster_id = null;
            $rosterRequest->is_offday = 1;
        }else{
            $rosterRequest->roster_id = $request->input('roster_id');
            $rosterRequest->is_offday = 0;
        }
        $rosterRequest->save();
        toastr()->success('Roster time updated successfully.');
        return redirect()->back();
    }

    public function reviseSubmitRoster(Request $request){
        $saveStatus = 0;
        $employee = Employee::find($request->input('employee_id'));
        $rosterRequest = RosterRequest::where('employee_id', $request->input('employee_id'))->get();

        // $rosterRequest->transform(function($item, $key) use ($employee){
        //     if($item->is_revised != 0){
        //         $item->is_revised = 1;
        //         $item->save();
        //         $toastrStatus = 1;
        //         // send notification to team leader
        //         Employee::find($employee->team->first()->team_lead_id)->userDetails->notify(new AppRosterRequest($employee));
        //     }else{
        //         $toastrStatus = 0;
        //     }
        // });

        foreach($rosterRequest as $item){
            if($item->is_revised == 0){
                $item->is_revised = 1;
                $item->save();
                $saveStatus = 1;

            }else{
                $saveStatus = 0;
            }
        }

        ($saveStatus) ? toastr()->success('Roster time submitted successfully for approval.') : toastr()->error('You already submitted for approval.');
        // send notification to team leader
        ($saveStatus) ? Employee::find($employee->team->first()->team_lead_id)->userDetails->notify(new AppRosterRequest($employee)) : '';
        return redirect()->back();
    }

    public function reviewView(Request $request, $notificationId = null){
        if($notificationId){
            auth()->user()->unreadNotifications->where('id', $notificationId)->markAsRead();
            return redirect()->route('user.roster.review.view');
        }



        $active = 'review-roster';
        if(!$request->date_from && !$request->date_to){
            //dd($request->date_from);

            $rosters = null;
            $rosterRequests = null;
            $rosterCount = null;
            $headers = null;
            return view('user.roster.review-roster', compact(
                'active',
                'rosterRequests',
                'rosters',
                'rosterCount',
                'headers'
            ));
        }

        $validator = Validator::make($request->all(), [
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        $start_date = $request->get('date_from');
        $end_date = $request->get('date_to');
        $teams = Team::where('team_lead_id', Auth::user()->employee_id)->first();
        foreach($teams->employees as $item){
            $team_member[] = $item->id;
        }
        $rosterRequests = RosterRequest::whereIn('employee_id', $team_member)->whereBetween('date', [$start_date, $end_date])->where('is_revised', 1)->with('employee')->with('roster')->get();



        $headers =  array_unique(array_column($rosterRequests->toArray(), 'date'));
        $rosterCount = RosterRequest::selectRaw('count(employee_id) as total_emp, date, roster_id')->whereBetween('date', [$start_date, $end_date])
                                ->groupBy('roster_id','date')
                                ->get()
                                ->reduce(function($test, $record){
                                    $test[$record->roster_id][$record->date] = $record->total_emp;
                                    return $test;
                                });
        $rosters = ($rosterCount) ? Roster::whereIn('id',array_keys($rosterCount))->get() : [];

        return view('user.roster.review-roster', compact(
            'active',
            'rosterRequests',
            'rosters',
            'rosterCount',
            'headers'
        ));

    }

    public function reviewSubmitRoster(Request $request){
        $rosterRequests = RosterRequest::whereIn('employee_id', $request->input('employee_id'))->get();
        $data_to_insert = [];
        // $data_to_update = [];
        foreach($rosterRequests as $item){
            $attendance = Attendance::where('employee_id', $item->employee_id)->where('date', $item->date)->first();
            if(!$attendance){
                $attendance = new Attendance();
                $attendance->employee_id = $item->employee_id;
                $attendance->date = $item->date;

                $attendance->roster_start = ($item->roster) ? date("Y-m-d H:i:s", strtotime($item->date.' '.$item->roster->roster_start)) : Null;
                if(isset($item->roster) && $item->roster->roster_end < $item->roster->roster_start ){
                    $attendance->roster_end = ($item->roster) ? date("Y-m-d H:i:s", strtotime("+1 day", strtotime($item->date.' '.$item->roster->roster_end))) : Null;
                }else{
                    $attendance->roster_end = ($item->roster) ? date("Y-m-d H:i:s", strtotime($item->date.' '.$item->roster->roster_end)) : Null;
                }

                if(!isset($item->roster)){
                    $attendance->status = AttendanceStatus::DAYOFF;
                }
                else{
                    $attendance->status = AttendanceStatus::ABSENT;
                }
                array_push($data_to_insert, $attendance->toArray());
            }else{

                $attendance->roster_start = ($item->roster) ? date("Y-m-d H:i:s", strtotime($item->date.' '.$item->roster->roster_start)) : Null;
                if(isset($item->roster) && $item->roster->roster_end < $item->roster->roster_start ){
                    $attendance->roster_end = ($item->roster) ? date("Y-m-d H:i:s", strtotime("+1 day", strtotime($item->date.' '.$item->roster->roster_end))) : Null;
                }else{
                    $attendance->roster_end = ($item->roster) ? date("Y-m-d H:i:s", strtotime($item->date.' '.$item->roster->roster_end)) : Null;
                }

                if(!isset($item->roster)){
                    $attendance->status = AttendanceStatus::DAYOFF;
                }
                elseif($attendance->punch_in){
                    $status = ($attendance->status) ? $attendance->status : AttendanceStatus::PRESENT;
                    $attendance->status = $status;
                }
                else{
                    $attendance->status = AttendanceStatus::ABSENT;
                }
                // array_push($data_to_update, $attendance->toArray());
                $attendance->save();
            }

        }
        if($data_to_insert){
            $insert = new Attendance();
            $insert->insert($data_to_insert);
        }

        toastr()->success('Roster time has successfully approved and updated.');

        return redirect()->back();

    }
}
