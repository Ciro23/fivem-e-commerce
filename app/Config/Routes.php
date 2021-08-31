<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group("", ["namespace" => "App\Controllers\Home"], function ($routes) {
	$routes->get("/", "HomeController::index", ["as" => "home"]);
	$routes->get("search/(:alpha)", "HomeController::search/$1", ["as" => "search"]);
});

// signup routes
$routes->group("signup", ["namespace" => "App\Controllers\UserAuth"], function ($routes) {
	$routes->get("", "SignupController::index", ["as" => "signup"]);
	$routes->post("", "SignupController::signup");
});

// login routes
$routes->group("login", ["namespace" => "App\Controllers\UserAuth"], function ($routes) {
	$routes->get("", "LoginController::index", ["as" => "login"]);
	$routes->post("", "LoginController::login");
});

// logout route
$routes->get("/logout", "UserAuth\LoginController::logout", ["as" => "logout"]);

// mod routes
$routes->group("", ["namespace" => "App\Controllers\Mod"], function ($routes) {
	$routes->get("mod/(:num)", "ModController::index/$1");

	$routes->get("upload-mod", "ModUploadController::index", ["as" => "upload_mod"]);
	$routes->post("upload-mod", "ModUploadController::uploadMod");

	$routes->get("manage-mods", "ModManageController::index", ["as" => "manage_mods"]);
	$routes->get("mod/(:num)/approve", "ModManageController::approve/$1");
	$routes->get("mod/(:num)/deny", "ModManageController::deny/$1");

	$routes->get("mod/(:num)/download", "ModDownloadController::download/$1");
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
