<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ReportBroadcast::class,
        Commands\AnnualLeaveGenerate::class,
        Commands\ImportDailyAttendance::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Annual Leave Generate
        $schedule->command('al:generate')->dailyAt('00:05');

        // daily backup
        $schedule->command('backup:run')->dailyAt('01:05');

        // cleaning old backup
        $schedule->command('backup:clean')->dailyAt('01:15');

        // monitor backup health
        $schedule->command('backup:monitor')->daily()->at('03:00');

        // cleaning old websocket statistics
        $schedule->command('websockets:clean')->daily()->at('02:00');

        // Report Broadcast
        $schedule->command('report:broadcast')->sundays();
        
        // Import Attendance
        $schedule->command('dailyAttendance:import')->daily()->at('05:00');
        
        // Update Attendance Status
        $schedule->command('attendanceStatus:update')->daily()->at('05:15');
        
        // Update Attendance Status
        $schedule->command('leaveStatusInAttendance:update')->daily()->at('06:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
