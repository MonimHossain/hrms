<?php

namespace App\Listeners;

use App\Events\LeaveApplyEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveApplyEventListener
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
     * @param  LeaveApplyEvent  $event
     * @return void
     */
    public function handle(LeaveApplyEvent $event)
    {
        dd($event);
    }
}
