<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DspUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;
    public $code;
    public $eq;

    public function __construct($event, $code, $eq)
    {
        $this->event = $event;
        $this->code = $code;
        $this->eq = $eq;
    }

    // Sửa ở đây: trả về array
    public function broadcastOn(): array
    {
        return [new Channel('public-channel')];
    }

    public function broadcastWith(): array
    {
        return [
            'event' => $this->event,
            'code' => $this->code,
            'eq' => $this->eq,
        ];
    }

    // // Tùy chọn: đổi tên event client nhận
    // public function broadcastAs(): string
    // {
    //     return $this->event; // ví dụ: "dsp.update"
    // }
}