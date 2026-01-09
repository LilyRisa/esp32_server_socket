<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DspController;

use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use App\WebSockets\DeviceSocketHandler;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/{any}', function () {
//     return view('spa'); // hoặc trả index.html
// })->where('any', '.*');


WebSocketsRouter::webSocket('/ws/dsp', DeviceSocketHandler::class);




Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'fetch_login']);
Route::post('/register', [UserController::class, 'register']);





Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.index');
    })->name('dashboard');

    // Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'index']);

     Route::get('/spa/account', [UserController::class, 'account'])->name('account');
     Route::get('account/change-password', [UserController::class, 'showChangePassword'])->name('account.password');
    Route::post('account/change-password', [UserController::class, 'updatePassword']);

    Route::get('account/change-name', [UserController::class, 'showChangeName'])->name('account.name');
    Route::post('account/change-name', [UserController::class, 'updateName']);

    // Devices
    Route::get('devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('devices/dsp', [DeviceController::class, 'dsp'])->name('devices.dsp');
    //dsp
    Route::post('/dsp/save', [App\Http\Controllers\DspController::class, 'save'])->name('dsp.save');
    // Route::get('/dsp/load', [App\Http\Controllers\DspController::class, 'load'])->name('dsp.load');
    Route::post('/dsp/get-presets', [App\Http\Controllers\DspController::class, 'getPresetsByDevice']);
    Route::post('/dsp/get-preset-detail', [App\Http\Controllers\DspController::class, 'getPresetDetail']);

// STREM
    Route::post('/dsp/stream', [App\Http\Controllers\DspController::class, 'streamDsp'])->name('dsp.stream');
        

    
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');
