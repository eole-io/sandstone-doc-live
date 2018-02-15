<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Ratchet\Wamp\WampConnection;
use Eole\Sandstone\Websocket\Topic;

$app = new Eole\Sandstone\Application();

// Sandstone requires JMS serializer
$app->register(new Eole\Sandstone\Serializer\ServiceProvider());

// Register and configure your websocket server
$app->register(new Eole\Sandstone\Websocket\ServiceProvider(), [
    'sandstone.websocket.server' => [
        'bind' => '0.0.0.0',
        'port' => '25569',
    ],
]);

/**
 * Simple chat topic
 */
$app->topic('chat/demo', function ($topicPattern) {
    return new class ($topicPattern) extends Topic
    {
        public function onPublish(WampConnection $conn, $topic, $event)
        {
            $this->broadcast([
                'message' => $event,
            ]);
        }
    };
});

// Encapsulate your application and run websocket server
$websocketServer = new Eole\Sandstone\Websocket\Server($app);

$websocketServer->run();
