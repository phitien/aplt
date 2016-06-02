<?php

namespace App\Platform\Traits;

use App\Platform\Config;
use App\Platform\Helper;

trait TokenTrait {
	/**
	 *
	 * @return string token
	 */
	public static function getToken() {
		if (! Helper::$_token)
			Helper::$_token = static::param ( Config::TOKEN_KEY );
		return Helper::$_token;
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	protected static function setToken($token) {
		Helper::$_token = $token;
	}
}
