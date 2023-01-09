<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $employee_id, $employer_id, $email;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($employee_id, $employer_id, $email)
    {
        $this->employee_id = $employee_id;
        $this->employer_id = $employer_id;
        $this->email = $email;
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
