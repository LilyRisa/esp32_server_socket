<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Device;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function create(Request $req)
    {
        $mac = $req->mac;
        $email = $req->email;
        $ip = $req->ip();

        if (!$mac || !$email) {
            return response()->json(['error' => 'missing_fields'], 400);
        }

        $user = User::where('email', $email)->first();
        $passwordPlain = null;
        $isNewUser = false;

        if (!$user) {
            // Nếu user chưa tồn tại -> tạo mới
            $passwordPlain = Str::random(10);
            $user = User::create([
                'email' => $email,
                'name' => explode('@', $email)[0],
                'password' => Hash::make($passwordPlain),
            ]);
            $isNewUser = true;
        }

        $user->refresh();

        $device = Device::updateOrCreate(
            ['mac' => $mac],
            [
                'user_id' => $user->id,
                'code' => strtoupper(Str::random(8)),
                'last_ip' => $ip,
            ]
        );

        // 3️Gửi mail
        $subject = 'Thiết bị mới đã được thêm vào hệ thống';
        $message = "Xin chào {$user->name},\n\n" .
            "Thiết bị mới của bạn đã được thêm vào hệ thống.\n" .
            "Mã thiết bị: {$device->code}\n" .
            "Địa chỉ IP: {$ip}\n\n";

        if ($isNewUser) {
            $message .= "Tài khoản của bạn đã được tự động tạo.\n" .
                "Email đăng nhập: {$email}\n" .
                "Mật khẩu tạm thời: {$passwordPlain}\n\n" .
                "Vui lòng đăng nhập và đổi mật khẩu sau khi sử dụng.";
        }
        try{
            Mail::raw($message, function ($m) use ($user, $subject) {
                $m->to($user->email)->subject($subject);
            });

        }catch(\Exception $e){

        }

        
        return response()->json([
            'code' => $device->code,
            'user_email' => $user->email,
            'new_user' => $isNewUser,
        ]);
    }

    public function update(Request $req)
    {
        $device = Device::where('code', $req->code)->first();
        if ($device) {
            $device->update([
                'mac' => $req->mac,
                'last_ip' => $req->ip()
            ]);
            return response()->json(['ok' => true]);
        }
        return response()->json(['ok' => false, 'error' => 'not_found']);
    }

    public function check(Request $req)
    {
        $code = $req->input('device_code');
        $device = Device::where('code', $code)->first();

        if ($device) {
            return response()->json([
                'valid' => true,
                'mac' => $device->mac,
                'ip' => $device->last_ip,
            ]);
        }

        return response()->json(['valid' => false]);
    }

    public function index()
    {
        $devices = Device::latest()->paginate(10);
        return view('devices.index', compact('devices'));
    }

   public function dsp()
    {
        // Lấy user hiện tại
        $user = Auth::user();

        // Lấy danh sách thiết bị thuộc user (sắp xếp mới nhất lên đầu)
        $devices = Device::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get(['id', 'code', 'mac', 'last_ip']);

        // Trả về view kèm danh sách thiết bị
        return view('devices.dsp', compact('devices'));
    }
}
