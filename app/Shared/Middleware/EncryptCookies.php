<?php

namespace App\Shared\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;
use App\Shared\Config;

class EncryptCookies extends BaseEncrypter {
	/**
	 * The names of the cookies that should not be encrypted.
	 *
	 * @var array
	 */
	protected $except = [ 
			Config::TOKEN_KEY 
	];
	//
}
