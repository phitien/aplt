<?php

namespace App\Media\Traits;

use App\Media\Config;
use App\Media\Models\User;
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
		if (! static::$_token) {
			static::$_token = static::param ( Config::TOKEN_KEY, null );
		}
		return static::$_token == Config::INVALID_TOKEN ? null : static::$_token;
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
	 * @var string $_userInfoFromRequest
	 */
	protected static $_userInfoFromRequest;
	/**
	 *
	 * @return string $_userInfoFromRequest
	 */
	protected static function getUserInfoFromRequest() {
		if (! static::$_userInfoFromRequest) {
			static::$_userInfoFromRequest = static::param ( Config::SESSION_KEY, null );
		}
		return static::$_userInfoFromRequest;
	}
	/**
	 *
	 * @param string $_userInfoFromRequest        	
	 * @return string $_userInfoFromRequest
	 */
	protected static function setUserInfoFromRequest($userInfoFromRequest) {
		static::$_userInfoFromRequest = $userInfoFromRequest;
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
		if (! static::$_user) {
			if (static::getToken ()) {
				try {
					// try to get user info by sending get user profile api to im
					$reponse = static::apiCallProfile ();
				} catch ( Exception $e ) {
				}
			}
			// if no user found, set it to guest
			if (! static::$_user)
				static::$_user = User::getGuest ();
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
