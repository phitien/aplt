<?php

namespace App\Platform\Traits;

use App\Platform\Config;

trait TokenTrait {
	/**
	 *
	 * @return string token
	 */
	public static function getToken() {
		if (! \App\Platform\Helper::$_token) {
			\App\Platform\Helper::$_token = static::param ( Config::TOKEN_KEY );
		}
		return \App\Platform\Helper::$_token == Config::INVALID_TOKEN ? null : \App\Platform\Helper::$_token;
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	protected static function setToken($token) {
		\App\Platform\Helper::$_token = $token;
	}
}
