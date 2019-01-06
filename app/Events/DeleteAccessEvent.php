<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteAccessEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event_id;
    public $ip;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event_id, $ip, $user)
    {
        $this->event_id = $event_id;
        $this->ip = $ip;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function broadcastAs() {
        return 'DeleteAccess';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Access');
    }
}
