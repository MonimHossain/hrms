<?php

namespace App\Jobs;

use App\Notifications\EmployeeHourCsvImport;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOfCompletedEmployeeHourImport implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->notify(new EmployeeHourCsvImport('Employee Hour CVS', ' upload successfully completed!', 'manage.salary.employee.hours'));
    }
}
