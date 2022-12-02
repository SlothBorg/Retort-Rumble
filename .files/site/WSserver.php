<?php
require __DIR__ . '/vendor/autoload.php';

use RetortRumble\WebSockets as WS;
use Ratchet\App as Ratchet;
use React\EventLoop as Loop;

    $dotenv = new Dotenv\Dotenv(__DIR__ . '/configs');
    $dotenv->load();

    $countdown = new WS\CountdownHandler(
        (int)getenv('APP_TIME'),
        (bool)getenv('SITE_ENV')
    );

    $loop = Loop\Factory::create();

    // once per second loop and execute function
    $loop->addPeriodicTimer(1, function () use ($countdown) {
        $countdown->doAction();
    });

    $app = new Ratchet(
        (string)getenv('APP_IP'),
        (int)getenv('APP_PORT'),
        (string)getenv('APP_LISTEN'),
        $loop
    );
    // specify the endpoint for the websocket
    $app->route('/chat', $countdown, ['*']);

    $app->run();
