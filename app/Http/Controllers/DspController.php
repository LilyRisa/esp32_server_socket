<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DspPreset;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ratchet\Client\connect;

use App\Events\DspUpdateEvent;

class DspController extends Controller
{
    public function save(Request $req)
    {
        $req->validate([
            'device_id' => 'required|exists:devices,id',
            'name' => 'required|string|max:100',
            'eq_data' => 'required|array|size:10',
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
            $device = Device::find($req->device_id);

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
        $code = $req->device_code;
        $eq = $req->eq;

        $ok = \App\WebSockets\DeviceSocketHandler::sendToDevice($code, [
            'event' => 'dsp.update',
            'eq' => $eq,
            'code' => $code,
        ]);

        return response()->json([
            'success' => $ok,
            'msg' => $ok ? 'DSP config sent to device' : 'Device not connected',
        ]);
    }
}
