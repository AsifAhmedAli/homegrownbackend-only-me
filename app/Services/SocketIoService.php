<?php


namespace App\Services;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class SocketIoService
{
    public static function initWebSocket()
    {
        return new Client(new Version2X(config('services.socket_url'), [
            'headers' => [
                'X-My-Header: websocket rocks',
                'Authorization: Bearer 12b3c4d5e6f7g8h9i'
            ]
        ]));
    }

    public static function emit($data) {
        $client = self::initWebSocket();
        $client->initialize();
        $client->emit('new-message', ['chatMessage' => $data]);
        $client->close();
    }
}
