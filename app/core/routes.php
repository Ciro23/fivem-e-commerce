<?php

// creates custom routes
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    // homepage route
    $r->addRoute("GET", "/", "HomeController/index");

    // signup, login and logout routes
    $r->addRoute("GET", "/{type:signup}[/[?{error}]]", "SignupController/index");
    $r->addRoute("POST", "/{type:signup}/action[/]", "SignupController/signup");
    $r->addRoute("GET", "/{type:login}[/[?{error}]]", "LoginController/index");
    $r->addRoute("POST", "/{type:login}/action[/]", "LoginController/login");
    $r->addRoute("GET", "/logout[/]", "LoginController/logout");

    // user routes
    $r->addRoute("GET", "/user/{user}[/]", "UserController/index");
});
