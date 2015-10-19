<?php
use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'Messages'], function ($routes) {

    $routes->connect('/messages', ['controller' => 'Messages']);
    $routes->connect('/threads', ['controller' => 'Threads']);
    $routes->connect('/messages/:action/*', ['controller' => 'Messages'], ['routeClass' => 'DashedRoute']);
    $routes->connect('/threads/:action/*', ['controller' => 'Threads'], ['routeClass' => 'DashedRoute']);
    $routes->fallbacks('DashedRoute');

    $routes->prefix('api', function ($routes) {
        $routes->extensions(['json','xml']);
        $routes->resources('Messages.Threads');
        $routes->resources('Messages.Messages');
        $routes->connect('/messages/:action/*', ['controller' => 'Messages']);
        $routes->connect('/threads/:action/*', ['controller' => 'Threads']);
        $routes->fallbacks('DashedRoute');
    });
});
