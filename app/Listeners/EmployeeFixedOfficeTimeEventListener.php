<?php

namespace App\Listeners;

use App\EmployeeFixedOfficeTime;
use App\Events\EmployeeFixedOfficeTimeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class EmployeeFixedOfficeTimeEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmployeeFixedOfficeTimeEvent  $event
     * @return void
     */
    public function handle(EmployeeFixedOfficeTimeEvent $event)
    {

        $data = [];
        foreach ($event->days as $day) {
            $data[] = [
                'employee_id' => $event->employee_id,
                'day' => $day,
                'roster_start' => ($day == 'Friday' || $day == 'Saturday') ?  null : '09:00:00',
                'roster_end' => ($day == 'Friday' || $day == 'Saturday') ? null : '18:00:00',
                'is_offday' => ($day == 'Friday' || $day == 'Saturday') ? 1 : 0,
            ];
        }
        //dump($data);
        DB::table('employee_fixed_office_times')->where('employee_id', $event->employee_id)->delete();
        DB::table('employee_fixed_office_times')->insert($data);
    }
}
