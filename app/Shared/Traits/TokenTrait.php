<?php

namespace App\Shared\Traits;

use App\Shared\Config;
use App\Shared\Helper;

trait TokenTrait {
	/**
	 *
	 * @return string token
	 */
	public static function getToken() {
		Helper::$_token = static::param ( Config::TOKEN_KEY );
		return Helper::$_token;
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	public static function setToken($token) {
		return Helper::$_token = $token;
	}
}
