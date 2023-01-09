<?php

namespace App\Console\Commands;

use App\Attendance;
use App\Employee;
use App\EmployeeFixedOfficeTime;
use App\Leave;
use App\Scopes\DivisionCenterScope;
use App\Utils\AttendanceStatus;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

class ImportDailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyAttendance:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import daily attendance from My Genex portal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->baseURL = 'https://my.genexinfosys.com';
    }

    public function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    public function attendanceUpdate($employee_id){
        $date = date('Y-m-d', strtotime('-1 day'));
        $day = date('l', strtotime('-1 day'));        
        $employee = Employee::withoutGlobalScopes()->where('id', $employee_id)->first();
        if($employee->employeeJourney->employee_status_id == 1){                            
            
            $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();                
            $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee->id)->first(); 
            $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();
            
            if($fixedRoster) {                    
                
                $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));

                if (!empty($existAttendance)) {
                    if ($existAttendance->punch_in) {
                        if ($fixedRoster->is_offday == 1) {
                            $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                        } else {
                            $roster_entry_time = strtotime($startTime);
                            $punch_in_time = strtotime($existAttendance->punch_in);
                            $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                            $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id :
                                ((Carbon::parse($startTime)->format('H:i:s') && $late > 15) ? AttendanceStatus::LATE :
                                    (($late > 15) ? AttendanceStatus::LATE :
                                        AttendanceStatus::PRESENT));
                        }
                    } else {                            
                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else if ($fixedRoster->is_offday == 1){
                            $status = AttendanceStatus::DAYOFF;
                        } else {
                            $status = AttendanceStatus::ABSENT;
                        }
                    }
                    DB::table('attendances')->where('date', $date)->where('employee_id', $employee->id)->update([
                        'roster_start' => $startTime,
                        'roster_end' => $bendTime,
                        'status' => $status
                    ]);
                } else {
                    if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                        $status = $leaveCheck->leave_type_id;
                    } else if ($fixedRoster->is_offday == 1){
                        $status = AttendanceStatus::DAYOFF;
                    } else {
                        $status = AttendanceStatus::ABSENT;
                    }
                    $dataArray = array(
                        'employee_id' =>  $employee->id,
                        'date' => $date,
                        'roster_start' => $startTime,
                        'roster_end' => $bendTime,
                        'status' => $status
                    );
                    DB::table('attendances')->insert($dataArray);                    
                }
            } else if ($existAttendance) {
                $startTime = date('Y-m-d H:i:s', strtotime($existAttendance->roster_start));
                $bendTime = date('Y-m-d H:i:s', strtotime($existAttendance->roster_end));

                if ($existAttendance->punch_in) {
                    if ($fixedRoster->roster_start == null) {
                        $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                    } else {
                        $roster_entry_time = strtotime($startTime);
                        $punch_in_time = strtotime($existAttendance->punch_in);
                        $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                        $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id :
                            ((Carbon::parse($startTime)->format('H:i:s') && $late > 15) ? AttendanceStatus::LATE :
                                (($late > 15) ? AttendanceStatus::LATE :
                                    AttendanceStatus::PRESENT));
                    }
                } else {                            
                    if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                        $status = $leaveCheck->leave_type_id;
                    } else if ($existAttendance->roster_start == null){
                        $status = AttendanceStatus::DAYOFF;
                    } else {
                        $status = AttendanceStatus::ABSENT;
                    }
                }
                DB::table('attendances')->where('date', $date)->where('employee_id', $employee->id)->update([
                    'roster_start' => $startTime,
                    'roster_end' => $bendTime,
                    'status' => $status
                ]);                
            }
        }  
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date('Y-m-d', strtotime('-1 day'));        
        $attendance = $this->callApi("GET", $this->baseURL."/api.php?dailyAttendanceReport=true&date=".$date, NULL);
        $attendance = json_decode($attendance);
        if(isset($attendance->data)){
            foreach($attendance->data as $attendance_data){
                $status = \App\Utils\AttendanceStatus::ABSENT;
                $remarks = '';
                if($attendance_data->work_hours < 7.5 && $attendance_data->work_hours > 4.5){
                    $status = \App\Utils\AttendanceStatus::HALF_DAY;
                    $remarks = 'Half Day';
                } else if($attendance_data->work_hours < 4.5){
                    $status = \App\Utils\AttendanceStatus::PRESENT;
                    $remarks = 'Working hour less than 4.5 hrs';
                } else if($attendance_data->work_hours > 7.5){
                    $status = \App\Utils\AttendanceStatus::PRESENT;
                    $remarks = 'Full Day';
                } else{
                    $status = \App\Utils\AttendanceStatus::ABSENT;
                    $remarks = '';
                }                
                if($attendance_data->checkCount < 2 && $attendance_data->checkCount % 2 == 1){
                    $remarks = $remarks . ', Checkout time missing';
                }
                $values = array(
                    'employee_id' => $attendance_data->employee_id,
                    'date' => $attendance_data->date,
                    'punch_in' => $attendance_data->punch_in,
                    'punch_out' => $attendance_data->punch_out,
                    'work_hours' => $attendance_data->work_hours,
                    'first_checkin' => $attendance_data->first_checkin,
                    'last_checkin' => $attendance_data->last_checkin,
                    'status' => $status,
                    'remarks' => $remarks,
                );
                DB::table('attendances')->insert($values);              
            }
        }
    }
}
