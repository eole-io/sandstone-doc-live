<?php

require_once __DIR__.'/base-app.php';

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Dispatch push event on Rest API call
 */
$app->post('api/hello/{name}', function ($name) use ($app) {
    $event = new HelloEvent();
    $event->name = $name;

    $app['dispatcher']->dispatch('event.hello', $event);

    return new JsonResponse(['hello' => $name]);
})->value('name', 'world');

// Forward event to websocket process
$app->forwardEventToPushServer('event.hello');

$app->run();
