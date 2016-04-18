<?php

namespace App\IM\Traits;

use Illuminate\Support\Facades\Cookie;
use App\IM\Config\Config;
use JWTAuth;
use App\IM\Exceptions\TokenNotFound;
use App\IM\Exceptions\UserNotFound;
use App\User;
use Exception;

trait UserTrait
{
	/**
	 *
	 * @var string
	 */
	protected static $__token;
	/**
	 *
	 * @return string token
	 */
	protected static function getToken() {
		if (! static::$__token) {
			static::$__token = Cookie::get ( Config::TOKEN_KEY, static::$__token = JWTAuth::getToken () );
		}
		return static::$__token;
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
	 * @var \App\User
	 */
	protected static $__user;
	/**
	 *
	 * @return \App\User
	 */
	protected static function getUser($throwExceptionIfNotFound = false) {
		if (! static::$__user || $throwExceptionIfNotFound) {
			$token = static::getToken ();
			if ($throwExceptionIfNotFound) {
				if (! $token) {
					throw new TokenNotFound ();
				} else {
					static::$__user = JWTAuth::authenticate ( $token );
					if (! static::$__user || static::$__user->isGuest ())
						throw new UserNotFound ();
				}
			} else {
				try {
					static::$__user = JWTAuth::authenticate ( $token );
				} catch ( Exception $e ) {
				}
				if (! static::$__user)
					static::$__user = User::getGuest ();
			}
		}
		return static::$__user;
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
