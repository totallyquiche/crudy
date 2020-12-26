<?php declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

use App\Router;

$router = new Router;

$router->register('/', 'HomeController::home');
$router->register('/thingamabob', 'ThingamabobController::index');

echo $router->callRouteMethod($_SERVER['REQUEST_URI']);