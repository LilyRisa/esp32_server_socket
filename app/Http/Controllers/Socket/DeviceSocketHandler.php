<?php

namespace App\Http\Controllers\Socket;

use Ratchet\ConnectionInterface;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler;

/**
 * DeviceSocketHandler — quản lý kết nối WebSocket giữa Laravel và ESP32
 */
class DeviceSocketHandler extends WebSocketHandler
{
    /**
     * Lưu danh sách thiết bị đang kết nối
     * @var array<string, ConnectionInterface>
     */
    protected static $devices = [];

    /**
     * Khi ESP32 kết nối
     */
    public function onOpen(ConnectionInterface $conn)
    {
        parent::onOpen($conn);
        echo "🔌 ESP32 connected: {$conn->resourceId}\n";
        $conn->send(json_encode(['status' => 'connected', 'id' => $conn->resourceId]));
    }

    /**
     * Khi nhận message từ ESP32
     */
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        echo "📩 Message from {$conn->resourceId}: $msg\n";

        // Parse JSON
        $data = json_decode($msg, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "⚠️ Invalid JSON from {$conn->resourceId}\n";
            $conn->send(json_encode(['error' => 'Invalid JSON']));
            return;
        }

        // Khi ESP32 gửi sự kiện "register"
        if (($data['event'] ?? '') === 'register') {
            $code = $data['code'] ?? 'unknown';
            $conn->device_code = $code;
            self::$devices[$code] = $conn;

            echo "✅ Device registered: {$code}\n";

            $conn->send(json_encode([
                'event' => 'registered',
                'status' => 'ok',
                'code' => $code,
            ]));
            return;
        }

        // Khi ESP gửi event khác (ví dụ status)
        if (($data['event'] ?? '') === 'status') {
            echo "📡 Device status from {$conn->device_code}: " . json_encode($data) . "\n";
            return;
        }

        // Mặc định phản hồi lại
        $conn->send(json_encode(['ack' => $data]));
    }

    /**
     * Khi ESP32 ngắt kết nối
     */
    public function onClose(ConnectionInterface $conn)
    {
        $code = $conn->device_code ?? 'unknown';

        if ($code !== 'unknown' && isset(self::$devices[$code])) {
            unset(self::$devices[$code]);
            echo "❌ Device {$code} disconnected (ID {$conn->resourceId})\n";
        } else {
            echo "❌ Unknown device disconnected (ID {$conn->resourceId})\n";
        }

        parent::onClose($conn);
    }

    /**
     * Khi có lỗi xảy ra
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "💥 Error on connection {$conn->resourceId}: {$e->getMessage()}\n";
        $conn->close();
    }

    /**
     * Hàm tĩnh để gửi lệnh từ Laravel xuống ESP32
     */
    public static function sendToDevice(string $deviceCode, $data): bool
    {
        if (!isset(self::$devices[$deviceCode])) {
            echo "⚠️ Device {$deviceCode} not connected.\n";
            return false;
        }

        $conn = self::$devices[$deviceCode];
        $payload = is_string($data) ? $data : json_encode($data);

        $conn->send($payload);
        echo "📤 Sent to {$deviceCode}: {$payload}\n";

        return true;
    }

    /**
     * Hàm gửi broadcast cho tất cả thiết bị đang kết nối (nếu cần)
     */
    public static function broadcastAll($data)
    {
        $payload = is_string($data) ? $data : json_encode($data);

        foreach (self::$devices as $code => $conn) {
            $conn->send($payload);
            echo "📡 Broadcast to {$code}: {$payload}\n";
        }
    }
}