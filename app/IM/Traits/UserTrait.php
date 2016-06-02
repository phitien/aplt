<?php

namespace App\IM\Traits;

use App\IM\Config;
use JWTAuth;
use App\IM\Models\User;
use Exception;

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
			static::$_token = static::param ( Config::TOKEN_KEY, JWTAuth::getToken () );
		return static::$_token;
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	protected static function setToken($token) {
		static::$_token = $token;
		return static::$_token;
	}
	/**
	 *
	 * @var \App\IM\Models\User
	 */
	protected static $_user;
	/**
	 *
	 * @return \App\IM\Models\User
	 */
	protected static function getUser() {
		static::$_user = User::getGuest ();
		$token = static::getToken ();
		if ($token) {
			try {
				static::$_user = JWTAuth::authenticate ( $token );
			} catch ( Exception $e ) {
				static::$_user = User::getGuest ();
			}
		}
		return static::$_user;
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected static function setUser(User $user) {
		static::$_user = $user;
	}
}
