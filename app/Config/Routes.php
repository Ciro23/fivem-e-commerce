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

// home
$routes->get(
	"/",
	"HomeController::index",
	[
		"namespace" => "App\Controllers\Home",
		"as" => "home",
	]
);

// signup
$routes->group(
	"signup",
	[
		"namespace" => "App\Controllers\UserAuth",
		"filter" => "can_login_or_signup",
	],
	function ($routes) {
		$routes->get("", "SignupController::index", ["as" => "signup"]);
		$routes->post("", "SignupController::signup");
});

// login
$routes->group(
	"login",
	[
		"namespace" => "App\Controllers\UserAuth",
		"filter" => "can_login_or_signup",
	],
	function ($routes) {
		$routes->get("", "LoginController::index", ["as" => "login"]);
		$routes->post("", "LoginController::login");
});

// logout
$routes->get("/logout", "UserAuth\LoginController::logout", ["as" => "logout"]);

// mods
$routes->get(
	"mods",
	"ModsController::index",
	[
		"namespace" => "App\Controllers\Mod",
	]
);

// mod view
$routes->get(
	"mod/(:num)",
	"ModController::index/$1",
	[
		"namespace" => "App\Controllers\Mod",
		"filter" => "can_view_mod",
	]
);

// mod search
$routes->get(
	"/search/(:alphanum)",
	"ModSearchController::search/$1",
	[
		"namespace" => "App\Controllers\Mod",
	]
);

// mod upload
$routes->group(
	"upload-mod",
	[
		"namespace" => "App\Controllers\Mod",
		"filter" => "can_upload_mod",
	],
	function ($routes) {
		$routes->get("", "ModUploadController::index", ["as" => "upload_mod"]);
		$routes->post("", "ModUploadController::uploadMod");
});

// mod edit
$routes->group(
	"mod/(:num)/edit",
	[
		"namespace" => "App\Controllers\Mod",
		"filter" => "can_edit_mod",
	],
	function ($routes) {
		$routes->get("", "ModEditController::index/$1", ["as" => "edit_mod"]);
		$routes->post("", "ModEditController::editMod/$1");
	}
);

// mod manage
$routes->group(
	"",
	[
		"namespace" => "App\Controllers\Mod",
		"filter" => "can_manage_mods",
	],
	function ($routes) {
		$routes->get("manage-mods", "ModManageController::index", ["as" => "manage_mods"]);
		$routes->get("mod/(:num)/approve", "ModManageController::approve/$1");
		$routes->get("mod/(:num)/deny", "ModManageController::deny/$1");
});

// mod download
$routes->get(
	"mod/(:num)/download",
	"ModDownloadController::download/$1",
	[
		"namespace" => "App\Controllers\Mod",
		"filter" => "can_download_mod",
	]
);

// user profile
$routes->get(
	"user/(:num)",
	"UserController::index/$1",
	[
		"namespace" => "App\Controllers\User",
		"filter" => "can_view_user",
	]
);

// user settings
$routes->group(
	"user/(:num)/settings",
	[
		"namespace" => "App\Controllers\User",
		"filter" => "can_edit_user",
	],
	function ($routes) {
		$routes->get("", "UserEditController::index/$1", ["as" => "edit_user"]);
		$routes->post("", "UserEditController::editUser/$1");
	}
);

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
