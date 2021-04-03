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

    // mod routes
    $r->addRoute("GET", "/mod/{id:\d+}[/[?{error}]]", "ModApproveController/index");

    // mod upload routes
    $r->addRoute("GET", "/mod/upload[/[?{error}]]", "ModUploadController/index");
    $r->addRoute("POST", "/mod/upload/action[/]", "ModUploadController/upload");

    // mod approve routes
    $r->addRoute("GET", "/mod/{id:\d+}/update-status/{status:\d+}[/]", "ModApproveController/updateStatus");

    // user routes
    $r->addRoute("GET", "/user/{user}[/]", "UserController/index");
});
