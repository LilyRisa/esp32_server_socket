<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\DspUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_version' => $user->token_version
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'token_version' => 1,
        ]);

        // 👉 AUTO LOGIN: tạo token luôn
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'message' => 'Register success',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}

