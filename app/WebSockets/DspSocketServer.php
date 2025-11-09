<?php

namespace App\WebSockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class DspSocketServer implements MessageComponentInterface
{
  protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "✅ DSP WebSocket server started...\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "🔌 New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "📩 Message from {$from->resourceId}: $msg\n";

        $data = json_decode($msg, true);
        if (!$data || !isset($data['code'])) {
            $from->send(json_encode(['error' => 'invalid_format']));
            return;
        }

        // Gửi lại cho tất cả ESP32 đang lắng nghe
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send(json_encode([
                    'type' => 'dsp_update',
                    'code' => $data['code'],
                    'eq' => $data['eq'] ?? []
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "❌ Connection {$conn->resourceId} closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "⚠️ Error: {$e->getMessage()}\n";
        $conn->close();
    }

}