<?php

// creates custom routes
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    // homepage route
    $r->addRoute("GET", "/", "HomeController/index");

    // signup, login and logout routes
    $r->addRoute("GET", "/signup[/[?{query}]]", "SignupController/index");
    $r->addRoute("POST", "/signup/action[/]", "SignupController/signup");
    $r->addRoute("GET", "/login[/[?{query}]]", "LoginController/index");
    $r->addRoute("POST", "/login/action[/]", "LoginController/login");
    $r->addRoute("GET", "/logout[/]", "LoginController/logout");

    // mod routes
    $r->addRoute("GET", "/mod/{id:\d+}[/[?{query}]]", "ModController/index");

    // mod upload routes
    $r->addRoute("GET", "/mod/upload[/[?{query}]]", "ModUploadController/index");
    $r->addRoute("POST", "/mod/upload/action[/]", "ModUploadController/uploadMod");

    // mod approve routes
    $r->addRoute("GET", "/mod/approve[/]", "ModApproveController/index");
    $r->addRoute("GET", "/mod/{id:\d+}/update-status/{status:\d+}[/]", "ModApproveController/updateModStatus");

    // user routes
    $r->addRoute("GET", "/user/{user}[/]", "UserController/index");
});
