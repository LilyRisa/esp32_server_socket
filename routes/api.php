<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create_code_device', [App\Http\Controllers\DeviceController::class, 'create']);
Route::post('/update_device', [App\Http\Controllers\DeviceController::class, 'update']);
Route::post('/check_code_device', [App\Http\Controllers\DeviceController::class, 'check']);
Route::post('/device/dsp', [App\Http\Controllers\DspController::class, 'fetch']);

// user  
Route::post('/user/login', [App\Http\Controllers\API\UserController::class, 'login']);
Route::post('/user/register', [App\Http\Controllers\API\UserController::class, 'register']);

Route::middleware(['auth:sanctum', 'token.version'])->group(function () {
    Route::get('/me', [App\Http\Controllers\API\UserController::class, 'me']);
    Route::get('/device/list', [App\Http\Controllers\API\DeviceController::class, 'list']);
});