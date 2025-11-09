<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Output\NullOutput;
use BeyondCode\LaravelWebSockets\Server\Logger\WebsocketsLogger;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

class WebSocketsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // // Tắt logger để tránh lỗi khi đăng ký route
        // $this->app->singleton(WebsocketsLogger::class, function () {
        //     return (new WebsocketsLogger(new NullOutput()))->enable(false);
        // });

        // ĐĂNG KÝ ROUTE TRONG REGISTER() ← SỬA BUG!
        // WebSocketsRouter::webSocket('/ws/dsp', \App\WebSockets\DeviceSocketHandler::class);
    }

    public function boot(): void
    {
        // Không đăng ký route ở đây nữa
    }
}