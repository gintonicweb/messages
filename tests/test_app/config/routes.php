<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::scope('/', function ($routes) {
    $routes->extensions(['json','xml']);
    $routes->resources('Messages.Threads');
    $routes->resources('Messages.Messages');
    $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);
    $routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);
});
Plugin::routes();
