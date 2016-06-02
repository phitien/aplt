<?php

namespace App\Media\Traits;

use App\Media\Config;
use App\Shared\Models\User;

trait UserTrait
{
	/**
	 *
	 * @var string
	 */
	protected static $_token;
	/**
	 *
	 * @return string token
	 */
	protected static function getToken() {
		if (! static::$_token)
			static::$_token = static::param ( Config::TOKEN_KEY, null );
		return static::$_token;
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	protected static function setToken($token) {
		static::$_token = $token;
	}
	/**
	 *
	 * @var \App\User
	 */
	protected static $_user;
	/**
	 *
	 * @return \App\User
	 */
	protected static function getUser() {
		return static::$_user ? static::$_user : static::setUser ( User::getGuest () );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected static function setUser(User $user) {
		static::$_user = $user;
	}
}
