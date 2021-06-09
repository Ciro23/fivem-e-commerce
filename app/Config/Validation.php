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

	public $user = [
		"email" => "required|valid_email|is_unique[users.email]",
		"username" => "required|alpha_numeric|min_length[4]|max_length[20]|is_unique[users.username]",
		"password" => "required|min_length[6]|max_length[72]",
		"confirm_password" => [
			"rules" => "required|matches[password]",
			"label" => "confirm password",
		],
	];

	public $login = [
		"email" => "required|are_credentials_correct[password]",
		"password" => "required",
	];

	public $login_errors = [
		"email" => [
			"are_credentials_correct" => "Credentials are not correct",
		],
	];

	public $mod = [
		"name" => "required|alpha_numeric_space|min_length[4]|max_length[30]|is_unique[mods.name]",
		"description" => "required|min_length[10]|max_length[3000]",
		"file" => [
			"rules" => "uploaded[file]|max_size[file,50000]|ext_in[file,zip,rar]",
			"label" => "Mod file",
		],
		"image" => [
			"rules" => "max_size[image,3000]|is_image[image]",
			"label" => "Mod image",
		]
	];
}
