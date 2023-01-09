<?php

namespace App\Http\Controllers\User\CsvUpload;

use App\Leave;
use App\Roster;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\Jobs\CsvScheduleRosterUploadJob;
use App\Jobs\CsvAttendenceUploadJob;
use App\Jobs\CsvScheduleRosterUpdate;
use App\Attendance;
use App\Utils\AttendanceStatus;
use App\Employee;
use App\Utils\LeaveStatus;
use Validator;

class CsvUploadController extends Controller
{


    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function index()
    {
        $active = 'exec-roster-upload';
        return view('user.roster.upload-roster', compact('active'));
    }


    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function saveRoster(Request $request)
    {
        // $file = $request->file('excel_file');
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $validator = Validator::make([
                'file' => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]);
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }

        $rosterResource = fopen($file, 'r');

        //Csv file column
        $header_data = [];
        $header = fgetcsv($rosterResource);
        $exceptFields = ['sl', 'name', 'dayoff', 'cell', 'team_lead', 'skill', 'shift', 'g', 'location'];

        //Remove extra Character
        foreach ($header as $title) {
            $header_data[] = iconv("UTF-8", "ISO-8859-1//IGNORE", strtolower($title));
        }


        $rosterKey = array_values(array_diff($header_data, $exceptFields));  //Employee id with days

        //CSV all Column data
        $data = [];
        while ($row = fgetcsv($rosterResource)) {
            $data = array_except(array_combine($header_data, $row), $exceptFields);
            $prepairdInsertData = $this->makeRosterRow($data, $rosterKey);
            // dd($prepairdInsertData);
            // CsvScheduleRosterUploadJob::dispatch($prepairdInsertData); //
            DB::transaction(function () use ($prepairdInsertData) {
                DB::table('attendances')->insert($prepairdInsertData);
            });
        }

        toastr()->success('New Schedule Roster successfully Uploaded !');
        return redirect()->route('user.roster.upload');
    }


    /**
     * @method: Make Roster Row Prepaird
     * @param :
     * @return array
     *
     */
    public function makeRosterRow($rows, $rosterKey)
    {
        $dataArray = [];
        $shift9 = '09:00:00';

        for ($i = 0; $i < sizeof($rosterKey); $i++) {
            if ($i == 0) continue; //Skip first index because first array is employer ID data

            //Generate Time formate convert to 12 Hour formate
            $times = [];

            if (strtoupper(preg_replace("/[^a-zA-Z]+/", "", $rows[$rosterKey[$i]])) != 'DAYOFF') {
                $times = explode("-", $rows[$rosterKey[$i]]);
            }

            $startTime = (!empty($times[0])) ? date("Y-m-d H:i:s", strtotime($rosterKey[$i] . ' ' . $times[0])) : NULL; //Roster Start Time with date

            if (!empty($times[1])) {
                if ($times[1] < $times[0]) {
                    $bendTime = date("Y-m-d H:i:s", strtotime($rosterKey[$i] . ' ' . $times[1] . ' +1 day')); //Roster End Time with 1 date Plus
                } else {
                    $bendTime = date("Y-m-d H:i:s", strtotime($rosterKey[$i] . ' ' . $times[1])); //Roster End Time with date
                }
            } else {
                $bendTime = NULL;
            }


            $rosterDate = date('Y-m-d', strtotime($rosterKey[$i])); //Roster Date
            $employeeId = $rows['id']; //Employee ID
            $employee = Employee::where('employer_id', $employeeId)->first();
            if(!$employee){
                toastr()->error('Unknown employer ID: '.$employeeId.'. Data is not inserted for this unknown ID', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                continue;
            }
            $existAttendance = Attendance::where('date', $rosterDate)->where('employee_id', $employee->id)->first(); //Check Exist Roster Data.
            $leaveCheck = Leave::where('employee_id', $employee->id)->where('start_date', '<=', $rosterDate)->where('end_date', '>=', $rosterDate)->where('leave_status', LeaveStatus::APPROVED)->first(); // check if advanced leave exist

            if (!empty($existAttendance)) {
                if ($existAttendance->punch_in) {
                    if (strtoupper(preg_replace("/[^a-zA-Z]+/", "", $rows[$rosterKey[$i]])) == 'DAYOFF') {
                        $status = ($leaveCheck && in_array($rosterDate, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                    } else {
                        $roster_entry_time = strtotime($startTime);
                        $punch_in_time = strtotime($existAttendance->punch_in);
                        $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                        $status = ($leaveCheck && in_array($rosterDate, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id :
                            ((($shift9 == Carbon::parse($startTime)->format('H:i:s')) && $late > 15) ? AttendanceStatus::LATE :
                                (($late > 15) ? AttendanceStatus::LATE :
                                    AttendanceStatus::PRESENT));
                    }
                } else {
                    $status = ($leaveCheck && in_array($rosterDate, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : ((strtoupper(preg_replace("/[^a-zA-Z]+/", "", $rows[$rosterKey[$i]])) == 'DAYOFF') ? AttendanceStatus::DAYOFF : AttendanceStatus::ABSENT);
                }
                DB::table('attendances')->where('date', $rosterDate)->where('employee_id', $employee->id)->update([
                    'roster_start' => $startTime,
                    'roster_end' => $bendTime,
                    'status' => $status
                ]);
            } else {
                $dataArray[] = [
                    'employee_id' =>  $employee->id,
                    'date' => $rosterDate,
                    'roster_start' => $startTime,
                    'roster_end' => $bendTime,
                    'status' => ($leaveCheck && in_array($rosterDate, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : ((strtoupper(preg_replace("/[^a-zA-Z]+/", "", $rows[$rosterKey[$i]])) == 'DAYOFF') ? AttendanceStatus::DAYOFF : AttendanceStatus::ABSENT) // Weekend status
                ];
            }

        }
        return $dataArray;
    }

    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function attendence()
    {
        $active = 'exec-attendance-upload';
        return view('user.attendance.upload-attendance', compact('active'));
    }

    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function saveAttendence(Request $request)
    {
        // $file = $request->file('excel_file');
        // $AttendenceResource = fopen($file,'r');
        // //Csv file column
        // $header_data = [];
        // $header =  fgetcsv($AttendenceResource);
        // $exceptFields = ['name','no'];

        // //Remove extra Character
        // foreach($header as $title){
        //     $header_data[] =  iconv("UTF-8","ISO-8859-1//IGNORE",strtolower($title));
        // }


        // //CSV all Column data
        // $data = [];
        // while($row = fgetcsv($AttendenceResource)) {
        //     $data = array_except(array_combine($header_data,$row),$exceptFields);
        //     $clockIn = date("H:i:s", strtotime($data['clock_in']));
        //     $clockOut = date("H:i:s", strtotime($data['clock_out']));

        //     $punchIn = (!empty($data['clock_in']))? date("Y-m-d H:i:s", strtotime($data['date'].' '.$clockIn)):NULL;

        //     if(!empty($data['clock_out'])){
        //         if($clockOut < $clockIn){
        //             $punchOut = date("Y-m-d H:i:s", strtotime($data['date'].' '.$clockOut . ' +1 day'));
        //         }else{
        //             $punchOut = date("Y-m-d H:i:s", strtotime($data['date'].' '.$clockOut));
        //         }
        //     }else{
        //         $punchOut = NULL;
        //     }

        //     $status = (!empty($data['clock_in'])) ? AttendanceStatus::PRESENT:AttendanceStatus::ABSENT;


        //     $updateData = [
        //         'punch_in' => $punchIn,
        //         'punch_out' => $punchOut,
        //         'status' => $status
        //     ];

        //     // dd($updateData);
        //     // dd($data);
        //     // CsvAttendenceUploadJob::dispatch($updateData, $data);

        //     // dip -->

        //     $workMinutes = Carbon::create($punchIn)->diffInMinutes(Carbon::create($punchOut));
        //     $workHours = intdiv($workMinutes, 60).':'. ($workMinutes % 60);

        //     $insertData[] = [
        //         'employee_id' => $data['ac_no'],
        //         'date' => date("Y-m-d", strtotime($data['date'])),
        //         'punch_in' => $punchIn,
        //         'punch_out' => $punchOut,
        //         'work_hours' => $workHours,
        //         'status' => $status
        //     ];


        // }
        // // dd($insertData);
        // $attendance = new Attendance();
        // $attendance->insert($insertData);


        toastr()->success('New Attendence successfully Uploaded !');

        return redirect()->route('attendence.upload');
    }


    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = [];
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
                $emp_id[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function importCsv(Request $request)
    {
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $validator = Validator::make([
                'file' => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]);
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }


        $attendanceArrs = $this->csvToArray($file);

        $data = [];
        $unknownEmployerId = [];

        $checkAttendances = Attendance::whereBetween('date', [$request->input('start_date'), $request->input('end_date')])->get();
        $checkLeaves = Leave::where('start_date', '>=', $request->input('start_date'))->where('start_date', '<=', $request->input('end_date'))->where('leave_status', LeaveStatus::APPROVED)->get();
        $employees = Employee::whereIn('employer_id', array_column($attendanceArrs, 'ac_no'))->with(['employeeJourney', 'fixedOfficeTime'])->get();
        // dd($employees->toArray());

        foreach ($attendanceArrs as $attendanceArr) {
            $clockIn = ($attendanceArr['Clock_In']) ? date("H:i:s", strtotime($attendanceArr['Clock_In'])) : null;
            $clockOut = ($attendanceArr['Clock_Out']) ? date("H:i:s", strtotime($attendanceArr['Clock_Out'])) : null;

            $punchIn = (!empty($attendanceArr['Clock_In'])) ? date("Y-m-d H:i:s", strtotime($attendanceArr['Date'] . ' ' . $attendanceArr['Clock_In'])) : NULL;

            if (!empty($attendanceArr['Clock_Out']) && $clockIn && $clockOut) {
                if ($clockIn > $clockOut) {
                    $punchOut = ($attendanceArr['Clock_Out']) ? date("Y-m-d H:i:s", strtotime($attendanceArr['Date'] . ' ' . $attendanceArr['Clock_Out'] . ' +1 day')) : null;
                } else {
                    $punchOut = ($attendanceArr['Clock_Out']) ? date("Y-m-d H:i:s", strtotime($attendanceArr['Date'] . ' ' . $attendanceArr['Clock_Out'])) : null;
                }
            } else {
                $punchOut = NULL;
            }


            $workMinutes = Carbon::create($punchIn)->diffInMinutes(Carbon::create($punchOut));
            $halfDayRangeStart = '06:00:00';
            $halfDayRangeEnd = '07:30:00';
            if($punchIn && $punchOut){
                $workHours = intdiv($workMinutes, 60) . ':' . ($workMinutes % 60);

                if($workHours > $halfDayRangeStart && $workHours < $halfDayRangeEnd) {
                    $attStatus = AttendanceStatus::HALF_DAY;
                }elseif($workHours < $halfDayRangeStart){
                    $attStatus = AttendanceStatus::ABSENT;
                }else{
                    $attStatus = null;
                }
            }else{
                $workHours = '0:0';
                $attStatus = null;
            }

            $employee = $employees->where('employer_id', $attendanceArr['ac_no'])->first();
            $shift9 = '09:00:00';

            if($employee){

                $attendance = $checkAttendances->where('employee_id', $employee->id)->where('date', date("Y-m-d", strtotime($attendanceArr['Date'])))->first();
                $leaveCheck = $checkLeaves->where('employee_id', $employee->id)->where('start_date', '<=', date("Y-m-d", strtotime($attendanceArr['Date'])))->where('end_date', '>=', date("Y-m-d", strtotime($attendanceArr['Date'])))->first(); // check if advanced leave exist

                // if($employee->id == 176 && date("Y-m-d", strtotime($attendanceArr['Date'])) == '2020-03-03'){
                //     dd($leaveCheck && in_array(date("Y-m-d", strtotime($attendanceArr['Date'])), $leaveCheck->leave_days));
                // }

                if (!$attendance) {
                    if (!$employee) continue;
                    $attendanceCreate = new Attendance();
                    $attendanceCreate->employee_id = $employee->id;
                    $attendanceCreate->date = date("Y-m-d", strtotime($attendanceArr['Date']));
                    if($employee->employeeJourney->is_fixed_officetime){
                        $fixed_office_time = $employee->fixedOfficeTime()->where('day', Carbon::create(date("Y-m-d", strtotime($attendanceArr['Date'])))->format('l'))->first();
                        $attendanceCreate->roster_start = date("Y-m-d", strtotime($attendanceArr['Date'])) . ' ' .$fixed_office_time->roster_start;
                        $attendanceCreate->roster_end = date("Y-m-d", strtotime($attendanceArr['Date'])) . ' ' .$fixed_office_time->roster_end;
                        if ($attendanceCreate->roster_start) {
                            $roster_entry_time = strtotime($attendanceCreate->roster_start);
                            $punch_in_time = strtotime($punchIn);
                            $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                            // $status = ($fixed_office_time->is_offday) ? AttendanceStatus::DAYOFF : (($leaveCheck) ? $leaveCheck->leave_type_id : ((($late > 30) ? AttendanceStatus::LATE : (($punchIn) ? AttendanceStatus::PRESENT : AttendanceStatus::ABSENT))));
                            $status = ($fixed_office_time->is_offday) ? AttendanceStatus::DAYOFF :
                                ($leaveCheck && (in_array(date("Y-m-d", strtotime($attendanceArr['Date'])), $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id :
                                    (($attStatus != null) ? $attStatus :
                                        (((($shift9 == Carbon::parse($attendanceCreate->roster_start)->format('H:i:s')) && $late > 30) ? AttendanceStatus::LATE :
                                            (($late > 10) ? AttendanceStatus::LATE :
                                                (($punchIn) ? AttendanceStatus::PRESENT :
                                                    AttendanceStatus::ABSENT))))));                        }
                        $attendanceCreate->status = $status;
                    }else{
                        $attendanceCreate->roster_start = null;
                        $attendanceCreate->roster_end = null;
                        $attendanceCreate->status = ($leaveCheck && (in_array(date("Y-m-d", strtotime($attendanceArr['Date'])), $leaveCheck->leave_days))) ? $leaveCheck->leave_type_id : AttendanceStatus::WITHOUT_ROSTER;
                    }
                    $attendanceCreate->punch_in = $punchIn;
                    $attendanceCreate->punch_out = $punchOut;
                    $attendanceCreate->work_hours = $workHours;
                    $attendanceCreate->created_at = Carbon::now()->toDateTimeString();
                    $attendanceCreate->updated_at = Carbon::now()->toDateTimeString();
                    $data[] = $attendanceCreate->toArray();

                    //dump($data);
                } else {
                    if ($attendance->roster_start) {
                        $roster_entry_time = strtotime($attendance->roster_start);
                        $punch_in_time = strtotime($punchIn);
                        $late = ($punch_in_time) ? round(($punch_in_time - $roster_entry_time) / 60, 2) : null;
                        $status = ($leaveCheck && (in_array(date("Y-m-d", strtotime($attendanceArr['Date'])), $leaveCheck->leave_days))) ? $leaveCheck->leave_type_id :
                            ((!$punch_in_time) ? AttendanceStatus::ABSENT :
                                (($attStatus != null) ? $attStatus :
                                    (((($shift9 == Carbon::parse($attendance->roster_start)->format('H:i:s')) && $late > 30) ? AttendanceStatus::LATE :
                                        (($late > 10) ? AttendanceStatus::LATE :
                                            AttendanceStatus::PRESENT)))));                    } elseif ($attendance->punch_in || $attendance->punch_out) {
                        $status = (!$leaveCheck && !(in_array(date("Y-m-d", strtotime($attendanceArr['Date'])), $leaveCheck->leave_days))) ? (($attendance->status != AttendanceStatus::DAYOFF) ? AttendanceStatus::WITHOUT_ROSTER : AttendanceStatus::DAYOFF) : $leaveCheck->leave_type_id;
                    } else {
                        $status = ($leaveCheck && (in_array(date("Y-m-d", strtotime($attendanceArr['Date'])), $leaveCheck->leave_days))) ? $leaveCheck->leave_type_id : (($attendance->status != AttendanceStatus::DAYOFF) ? AttendanceStatus::ABSENT : AttendanceStatus::DAYOFF);
                    }
                    $attendance->punch_in = $punchIn;
                    $attendance->punch_out = $punchOut;
                    $attendance->work_hours = $workHours;
                    $attendance->status = $status;
                    $attendance->save();
                }
            }else{
                $unknownEmployerId[] = $attendanceArr['ac_no'];
            }
        }

        // return ($data);
        if ($data) {
            DB::transaction(function () use ($data) {
                $chunks = array_chunk($data,100);
                foreach($chunks as $chunk){
                    DB::table('attendances')->insert($chunk);
                }
            });
        }
        foreach ($unknownEmployerId  as $item){
            toastr()->error('Unknown employer ID '.$item.'. Data is not inserted for this unknown ID', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        }

        toastr()->success('New Attendence successfully Uploaded !', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);

        return redirect()->route('user.attendance.view');
    }


}


