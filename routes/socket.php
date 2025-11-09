<?php

use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use App\Http\Controllers\Socket\DeviceSocketHandler;



WebSocketsRouter::webSocket('/ws/dsp', DeviceSocketHandler::class);