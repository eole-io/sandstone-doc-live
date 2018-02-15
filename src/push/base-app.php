<?php

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/HelloEvent.php';

$app = new Eole\Sandstone\Application([
    'debug' => true,
]);

// Sandstone requires JMS serializer
$app->register(new Eole\Sandstone\Serializer\ServiceProvider());

// Register and configure your websocket server
$app->register(new Eole\Sandstone\Websocket\ServiceProvider(), [
    'sandstone.websocket.server' => [
        'bind' => '0.0.0.0',
        'port' => '25570',
    ],
]);

// Register Push Server and ZMQ bridge extension
$app->register(new \Eole\Sandstone\Push\ServiceProvider());
$app->register(new \Eole\Sandstone\Push\Bridge\ZMQ\ServiceProvider(), [
    'sandstone.push.server' => [
        'bind' => '0.0.0.0',
        'host' => 'push-websocket-server',
        'port' => 5555,
    ],
]);

// Register cors to allow ajax requests from any origin
$app->register(new \JDesrosiers\Silex\Provider\CorsServiceProvider());
$app['cors-enabled']($app);

// Add HelloEvent serializer metadata
$app['serializer.builder']
    ->addMetadataDir(__DIR__)
;
