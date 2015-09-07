<?php
use Cake\Routing\Router;

Router::plugin('Messages', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
