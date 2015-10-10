<?php
use Cake\Routing\Router;

Router::plugin('Messages', function ($routes) {
    $routes->extensions(['json','xml']);
    $routes->resources('Threads');
    $routes->fallbacks('DashedRoute');
});
