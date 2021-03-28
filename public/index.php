<?php

session_start();

// composer autoload
require_once __DIR__ . "/../vendor/autoload.php";

// saves the env vars in the $_ENV superglobal
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../app/config/");
$dotenv->load();

// includes the custom routes
require_once __DIR__ . "/../app/core/routes.php";

// gets the current route
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $controller = "PageNotFoundController";
        $method = "index";
        $vars = [];
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // gets the controller and the method
        list($controller, $method) = explode("/", $handler);

        break;
}

$controller = new $controller();
call_user_func_array([$controller, $method], $vars);
