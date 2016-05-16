<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config;

trait TokenTrait {
	/**
	 *
	 * @return string token
	 */
	public static function getToken() {
		if (! \App\Ezsell\Helper::$_token) {
			\App\Ezsell\Helper::$_token = static::param ( Config::TOKEN_KEY );
		}
		return \App\Ezsell\Helper::$_token == Config::INVALID_TOKEN ? null : \App\Ezsell\Helper::$_token;
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	protected static function setToken($token) {
		\App\Ezsell\Helper::$_token = $token;
	}
}
