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

class UpdateAttendanceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendanceStatus:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync daily attendance status';

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
        $date = date('Y-m-d', strtotime('-1 day'));
        $day = date('l', strtotime('-1 day'));
        $remarks = '';
        $employees = EmployeeFixedOfficeTime::distinct()->pluck('employee_id');

        foreach($employees as $employee_id){
            $remarks = '';
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
                                
                                // $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id :
                                //     ((Carbon::parse($startTime)->format('H:i:s') && $late > 30) ? AttendanceStatus::LATE :
                                //         (($late > 10) ? AttendanceStatus::LATE :
                                //             AttendanceStatus::PRESENT));
                                
                                $status = AttendanceStatus::PRESENT;
                                // if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                //     $status = $leaveCheck->leave_type_id;
                                // } else if(Carbon::parse($startTime)->format('H:i:s') && $late > 30){
                                //     $status = AttendanceStatus::LATE;
                                // } else if($late > 10) {
                                //     $status = AttendanceStatus::LATE;
                                // }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 4.5){
                                //     $status = AttendanceStatus::ABSENT;
                                // }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 7.5){
                                //     $status = AttendanceStatus::HALF_DAY;
                                // }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') > 7.5){
                                //     $status = AttendanceStatus::PRESENT;
                                // } else {
                                //     $status = AttendanceStatus::PRESENT;
                                // }
                                if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                    $status = $leaveCheck->leave_type_id;
                                } else if(Carbon::parse($startTime)->format('H:i:s') && $late > 15){
                                    $status = AttendanceStatus::LATE;
                                    $remarks = $existAttendance->remarks;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 4.5){
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 7.5){
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') > 7.5){
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                } else {
                                    $status = AttendanceStatus::PRESENT;
                                    $remarks = $existAttendance->remarks;
                                }
                            }
                        } else {                            
                            if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                $status = $leaveCheck->leave_type_id;
                            } else if ($fixedRoster->is_offday == 1){
                                $status = AttendanceStatus::DAYOFF;
                                $remarks = '';
                            } else {
                                $status = AttendanceStatus::ABSENT;
                                $remarks = '';
                            }
                        }
                        DB::table('attendances')->where('date', $date)->where('employee_id', $employee->id)->update([
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'status' => $status,
                            'remarks' => $remarks
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
                            'status' => $status,
                            'remarks' => $remarks
                        );
                        DB::table('attendances')->insert($dataArray);                    
                    }
                }
            }             
        }  
    }
}
