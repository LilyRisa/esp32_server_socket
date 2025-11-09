<?php

use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use App\WebSockets\DeviceSocketHandler;


WebSocketsRouter::webSocket('/ws/dsp', DeviceSocketHandler::class);