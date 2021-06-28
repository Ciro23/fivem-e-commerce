<?php

namespace Config;

use App\Filters\IsModApproved;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use App\Filters\IsUserLoggedIn;
use App\Filters\IsUserNotLoggedIn;
use App\Filters\IsUserAdmin;

class Filters extends BaseConfig {
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'     => CSRF::class,
		'toolbar'  => DebugToolbar::class,
		'honeypot' => Honeypot::class,
		'is_user_logged_in' => IsUserLoggedIn::class,
		'is_user_not_logged_in' => IsUserNotLoggedIn::class,
		'is_user_admin' => IsUserAdmin::class,
		'is_mod_approved' => IsModApproved::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			// 'csrf',
		],
		'after'  => [
			'toolbar',
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [
		'is_user_logged_in' => ['before' => ['/mod/upload', '/mod/manage', '/mod/download/*', '/mod/approve/*', '/mod/deny/*']],
		'is_user_not_logged_in' => ['before' => ['/signup', '/login']],
		'is_user_admin' => ['before' => ['/mod/manage', '/mod/approve/*', '/mod/deny/*']],
		'is_mod_approved' => ['before' => ['/mod/download/*']],
	];
}
