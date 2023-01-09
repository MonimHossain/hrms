<?php

namespace App\Console\Commands;

use App\Attendance;
use App\Leave;
use App\Utils\LeaveStatus;
use Illuminate\Console\Command;

class UpdateLeaveInAttendanceTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaveStatusInAttendance:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This updates leave status is attendance table';

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
        $from = date('Y-m-d', strtotime('-15 day'));
        $to = date('Y-m-d');
        $day = date('l', strtotime('-15 day'));
        $remarks = '';
        $leaveCheck = Leave::whereBetween('start_date', [$from, $to])->where('leave_status', LeaveStatus::APPROVED)->get();
        foreach($leaveCheck as $leave){
            foreach (json_decode($leave->leave_days) as $leaveDay) {
                $attendance = Attendance::where('employee_id', $leave->employee_id)->orderBy('id', 'desc')->first();
                if ($attendance) {        
                    $attendance->status = $leave->leave_type_id;
                    $attendance->save();
                }
            }
        }
    }
}
