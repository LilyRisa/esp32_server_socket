<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DspUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $code;
    public $eq;
    public $event;

    public function __construct($event, $code, $eq)
    {
        $this->code = $code;
        $this->eq = $eq;
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return new Channel('public-channel');
    }
    public function broadcastWith()
    {
        return [
            'code' => $this->code,
            'event' => $this->event,
            'eq' => $this->eq,
        ];
    }
}
