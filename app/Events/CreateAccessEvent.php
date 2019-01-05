<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateAccessEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event_id;
    public $ip;
    public $user_text_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event_id, $ip, $user_text_id)
    {
        $this->event_id = $event_id;
        $this->ip = $ip;
        $this->user_text_id = $user_text_id;
    }

    /**
     * @return string
     */
    public function broadcastAs() {
        return 'CreateAccess';
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
