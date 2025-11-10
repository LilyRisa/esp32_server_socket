<?php

namespace App\WebSockets;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use Predis\Client as RedisClient;

class DeviceSocketHandler implements MessageComponentInterface
{
    protected static array $connections = [];

    // public function __construct()
    // {
    //     // Tạo kết nối Redis
    //     $redis = new RedisClient('tcp://127.0.0.1:6379' . "?read_write_timeout=0");

    //     // Tạo 1 vòng lặp non-blocking để nghe Redis
    //     // (sử dụng timer tick của Ratchet)
    //     $loop = \React\EventLoop\Loop::get();
    //     $pubsub = $redis->pubSubLoop();

    //     $loop->addPeriodicTimer(0.5, function () use ($pubsub) {
    //         foreach ($pubsub as $message) {
    //             if ($message->kind === 'message') {
    //                 $data = json_decode($message->payload, true);
    //                 $this->broadcastToAll($data);
    //             }
    //         }
    //     });

    //     // Subscribe kênh Redis
    //     $pubsub->subscribe('ws:dsp');
    // }

    public function onOpen($conn)
    {
        self::$connections[$conn->resourceId] = $conn;
        echo " Client connected: {$conn->resourceId}\n";
    }

    public function onClose($conn)
    {
        unset(self::$connections[$conn->resourceId]);
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "⚠️ Error: {$e->getMessage()}\n";
        $conn->close();
    }
    public function onMessage(ConnectionInterface $conn, MessageInterface $msg) {}

    protected function broadcastToAll($data)
    {
        $payload = json_encode($data);
        foreach (self::$connections as $conn) {
            if ($conn) {
                $conn->send($payload);
            }
        }
    }
}
