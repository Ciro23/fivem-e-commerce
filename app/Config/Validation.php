<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validation\UserRules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
		UserRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $signup = [
		"email" => "required|valid_email|is_unique[users.email]",
		"username" => "required|min_length[4]|max_length[20]|is_unique[users.username]",
		"password" => "required|min_length[6]|max_length[72]",
		"confirm_password" => "required|matches[password]",
	];

	public $signup_errors = [
		"email" => [
			"is_unique" => "The email is already registered",
		],

		"username" => [
			"is_unique" => "The username is already taken",
		],
	];

	public $login = [
		"email" => "required",
		"password" => "required|are_credentials_correct[email, password]",
	];

	public $login_errors = [
		"password" => [
			"are_credentials_correct" => "Credentials are not correct",
		],
	];
}
