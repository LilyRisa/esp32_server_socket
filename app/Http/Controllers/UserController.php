<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\DspUpdateEvent;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function fetch_login(Request $req)
    {
        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'user' => Auth::user()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email hoặc mật khẩu không đúng.'
        ]);
    }
    public function register(Request $req)
    {
        $req->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = \App\Models\User::create([
            'email' => $req->email,
            'name' => $req->name,
            'password' => bcrypt($req->password),
        ]);

        // Tự động đăng nhập user sau khi đăng ký
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công! Bạn đã được đăng nhập.',
            'redirect' => route('dashboard'), // để frontend chuyển hướng
        ]);
    }
    public function showChangePassword()
    {
        return view('account.change-password');
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($req->password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function showChangeName()
    {
        return view('account.change-name');
    }

    public function updateName(Request $req)
    {
        $req->validate([
            'name' => 'required|min:3',
        ]);

        $user = Auth::user();
        $user->name = $req->name;
        $user->save();

        return back()->with('success', 'Cập nhật tên hiển thị thành công!');
    }
    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/login');
    }
}
