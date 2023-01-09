<?php

namespace App\Jobs;

use App\Notifications\EmployeeAttendanceCsvImport;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class NotifyUserOfCompletedEmployeeAttendanceImport implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->notify(new EmployeeAttendanceCsvImport('Employee Attendance CVS', ' upload successfully completed!', 'manage.salary.employee.attendance'));
    }
}
