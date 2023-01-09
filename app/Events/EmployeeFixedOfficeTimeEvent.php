<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmployeeFixedOfficeTimeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $employee_id, $days;

    /**
     * Create a new event instance.
     *
     * @param $employee_id
     * @param $days
     */
    public function __construct($employee_id, $days)
    {
        $this->employee_id = $employee_id;
        $this->days = $days;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
