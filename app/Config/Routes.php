<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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
$routes->get('/', 'Home::index');

// signup routes
$routes->group("signup", ["namespace" => "App\Controllers\Signup"], function ($routes) {
	$routes->get("", "SignupController::index");
	$routes->post("", "SignupController::signup");
});

// login routes
$routes->group("login", ["namespace" => "App\Controllers\Login"], function ($routes) {
	$routes->get("", "LoginController::index");
	$routes->post("", "LoginController::login");
});

// mod routes
$routes->group("mod", ["namespace" => "App\Controllers\Mod"], function ($routes) {
	$routes->get("(:num)", "ModController::index/$1");

	$routes->get("mod/upload/", "ModUploadController::index");
	$routes->post("mod/upload/action", "ModUploadController::uploadMod");

	$routes->get("mod/approve", "ModApproveController::index");
	$routes->get("mod/approve/(:num)/update-status/(:num)", "ModApproveController::updateModStatus/$1/$2");
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
