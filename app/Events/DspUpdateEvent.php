<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DspUpdateEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $eventName;
    public $code;
    public $eq;

    public function __construct(string $eventName, string $code, array $eq)
    {
        $this->eventName = $eventName;
        $this->code = $code;
        $this->eq = $eq;
    }

    public function broadcastOn(): array
    {
        return [new Channel('public-channel')];
    }

    public function broadcastAs(): string
    {
        return $this->eventName; // "dsp.update"
    }

    public function broadcastWith(): array
    {
        return [
            'code' => $this->code,
            'eq' => $this->eq,
            'event' => $this->eventName,
        ];
    }
}