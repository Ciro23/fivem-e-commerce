<?php

namespace Config;

use App\Filters\DoesModExist;
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

		'can_login_or_signup' => [
			IsUserNotLoggedIn::class,
		],

		'can_upload_mod' => [
			IsUserLoggedIn::class,
		],

		'can_manage_mods' => [
			IsUserLoggedIn::class,
			IsUserAdmin::class,
		],

		'can_view_mod' => [
			DoesModExist::class,
			IsModApproved::class,
		],

		'can_download_mod' => [
			DoesModExist::class,
			IsModApproved::class,
			IsUserLoggedIn::class,
		],
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
	public $filters = [];
}
