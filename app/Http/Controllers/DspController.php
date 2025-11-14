<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DspPreset;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use WebSocket\Client;
use App\Models\DeviceEq;

use App\Events\DspUpdateEvent;

class DspController extends Controller
{
    public function save(Request $req)
    {
        $req->validate([
            'device_id' => 'required|max:100',
            'name' => 'required|string|max:100',
            'eq_data' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // 1️⃣ Tìm hoặc tạo preset
            $preset = DspPreset::where('user_id', Auth::id())
                ->where('name', $req->name)
                ->first();

            if ($preset) {
                $preset->update(['eq_data' => $req->eq_data]);
            } else {
                $preset = DspPreset::create([
                    'user_id' => Auth::id(),
                    'name' => $req->name,
                    'eq_data' => $req->eq_data,
                ]);
            }

            // 2️⃣ Ghi link giữa device và preset

            $device = Device::where("code", $req->device_id)->first();

            // Xóa liên kết cũ (nếu có) và tạo mới
            $device->dspPreset()->detach($preset->id);
            $device->dspPreset()->attach($preset->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ Cấu hình DSP đã được lưu và gán cho thiết bị!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '❌ Lỗi khi lưu DSP: ' . $e->getMessage()
            ]);
        }
    }

    public function load(Request $req)
    {
        $req->validate(['device_id' => 'required|exists:devices,id']);

        $link = DB::table('device_dsp_links')
            ->where('device_id', $req->device_id)
            ->first();

        if (!$link || !$link->dsp_preset_id) {
            return response()->json(['success' => false, 'message' => 'Chưa có cấu hình DSP cho thiết bị này.']);
        }

        $preset = DspPreset::find($link->dsp_preset_id);

        return response()->json([
            'success' => true,
            'preset' => $preset,
        ]);
    }
    public function getPresetsByDevice(Request $req)
    {
        $device = Device::find($req->device_id);
        if (!$device) return response()->json([]);

        return response()->json(
            $device->dspPreset()
                ->where('user_id', Auth::id())
                ->select('dsp_presets.id', 'dsp_presets.name')
                ->get()
        );
    }

    public function getPresetDetail(Request $req)
    {
        $preset = DspPreset::find($req->preset_id);
        if (!$preset) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $preset->id,
                'name' => $preset->name,
                'eq_data' => $preset->eq_data,
            ]
        ]);
    }

    public function streamDsp(Request $req)
    {
        $code = $req->input("device_code");
        $eq = $req->input("eq_data");
        $payload = [
            'event' => 'dsp.update',
            'code'  => $code ?: 'broadcast', // có thể null → broadcast toàn bộ
            'eq'    => $eq,
        ];
        DeviceEq::updateOrCreate(['device_code' => $code],$eq);
        // $client = new Client("ws://127.0.0.1:6001/ws/dsp");
        // $client->send(json_encode($payload));
        // $client->close();
        event(new DspUpdateEvent("dsp.update", $code, $eq));
        // $redis = new \Predis\Client('tcp://10.0.0.1:6379' . "?read_write_timeout=0");
        // $redis->publish('ws:dsp', json_encode($payload));
        // // \App\WebSockets\DeviceSocketHandler::broadcast($payload);
        return response()->json([
            'success' => true,
            'message' => 'Broadcasted DSP to all connected devices'
        ]);
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'device_code' => 'required|string',
        ]);

        $deviceCode = $request->input('device_code');

        $record = DeviceEq::where('device_code', $deviceCode)->first();

        if (! $record) {
            // Nếu không có, trả cấu trúc rỗng (hoặc 404 tuỳ bạn)
            return response()->json([
                'code' => $deviceCode,
                'eq' => null
            ], 200);
        }

        // Trả về theo mẫu bạn muốn: code + eq object
        return response()->json([
            'code' => $record->device_code,
            'eq' => [
                'clarity' => $record->clarity,
                'ambience' => $record->ambience,
                'surround' => $record->surround,
                'dynamic_boost' => $record->dynamic_boost,
                'bass_boost' => $record->bass_boost,
                'eq' => $record->eq ?? []
            ]
        ], 200);
    }
}
