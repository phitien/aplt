<?php

namespace App\IM\Traits;

use App\IM\Config\Config;
use JWTAuth;
use App\IM\Exceptions\TokenNotFound;
use App\IM\Exceptions\UserNotFound;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
		if (! static::$_token) {
			static::$_token = request ()->header ( Config::TOKEN_KEY, Cookie::get ( Config::TOKEN_KEY, static::$_token = JWTAuth::getToken () ) );
		}
		return static::$_token == Config::INVALID_TOKEN ? null : static::$_token;
	}
	/**
	 *
	 * @return string token
	 */
	protected function token() {
		return static::getToken ();
	}
	/**
	 *
	 * @param string $token        	
	 * @return string token
	 */
	protected function setToken($token) {
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
	protected static function getUser($throwExceptionIfNotFound = false) {
		if (! static::$_user || $throwExceptionIfNotFound) {
			$token = static::getToken ();
			if ($throwExceptionIfNotFound) {
				if (! $token) {
					throw new TokenNotFound ();
				} else {
					static::$_user = JWTAuth::authenticate ( $token );
					if (! static::$_user || static::$_user->isGuest ())
						throw new UserNotFound ();
				}
			} else {
				try {
					static::$_user = JWTAuth::authenticate ( $token );
				} catch ( Exception $e ) {
				}
				if (! static::$_user)
					static::$_user = User::getGuest ();
			}
		}
		return static::$_user;
	}
	/**
	 *
	 * @param User $user
	 */
	protected function setUser(User $user) {
		static::$_user = $user;
	}
	/**
	 *
	 * @param string $throwExceptionIfNotFound        	
	 * @return \App\User
	 */
	protected function user($throwExceptionIfNotFound = false) {
		return static::getUser ( $throwExceptionIfNotFound );
	}
}
