<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use App\Http\Controllers\Socket\DeviceSocketHandler;

class WebSocketRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ⚡ Đăng ký thủ công WebSocket Route — tránh IoC container
        WebSocketsRouter::getRouter()->webSocket('/ws/dsp', new DeviceSocketHandler());
    }
}