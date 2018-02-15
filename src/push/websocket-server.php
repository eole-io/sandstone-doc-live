<?php

require_once __DIR__.'/base-app.php';

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eole\Sandstone\Websocket\Topic;

/**
 * Topic that broadcast push event
 */
$app->topic('push/demo', function ($topicPattern) {
    return new class ($topicPattern) extends Topic implements EventSubscriberInterface
    {
        public static function getSubscribedEvents()
        {
            return [
                'event.hello' => 'onHelloEvent',
            ];
        }

        public function onHelloEvent(HelloEvent $event)
        {
            $this->broadcast([
                'message' => "Someone called Rest Api /api/hello. Hello $event->name !",
            ]);
        }
    };
});

// Encapsulate your application and run websocket server
$websocketServer = new Eole\Sandstone\Websocket\Server($app);

$websocketServer->run();
