<?php

namespace App\WebSockets;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;


class DeviceSocketHandler implements MessageComponentInterface
{
    protected static array $devices = [];

    public function onOpen(ConnectionInterface $conn)
    {
        echo "ESP32 connected (ID: {$conn->resourceId})\n";
        $conn->send(json_encode([
            'event' => 'connected',
            'status' => 'ok',
        ]));
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        $data = json_decode($msg, true);
        if (!$data) {
            $conn->send(json_encode(['error' => 'invalid_json']));
            return;
        }

        if (($data['event'] ?? '') === 'register') {
            $code = $data['code'] ?? 'unknown';
            $conn->device_code = $code;
            self::$devices[$code] = $conn;
            echo "Registered: {$code}\n";
            $conn->send(json_encode(['event'=>'registered','code'=>$code]));
            return;
        }

        $conn->send(json_encode(['ack'=>$data]));
    }

    public function onClose(ConnectionInterface $conn)
    {
        $code = $conn->device_code ?? null;
        if ($code && isset(self::$devices[$code])) {
            unset(self::$devices[$code]);
            echo "Disconnected: {$code}\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    public static function sendToDevice(string $deviceCode, $data)
    {
        if (!isset(self::$devices[$deviceCode])) return false;
        $payload = is_string($data) ? $data : json_encode($data);
        self::$devices[$deviceCode]->send($payload);
        echo "Sent to {$deviceCode}: {$payload}\n";
        return true;
    }
}