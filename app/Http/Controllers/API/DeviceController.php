<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\DspUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Device;

class DeviceController extends Controller
{

    public function list(Request $request){
        $user = $request->user();
        $devices = Device::where('user_id', $user->id)->get();
        return response()->json($devices);
    }
   
}

