<?php
use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'Messages'], function ($routes) {

    $routes->prefix('api', function ($routes) {
        $routes->extensions(['json','xml']);
        $routes->resources('Messages.Threads');
        $routes->resources('Messages.Messages');
        $routes->connect('/messages/:action/*', ['controller' => 'Messages']);
        $routes->connect('/threads/:action/*', ['controller' => 'Threads']);
    });
});
