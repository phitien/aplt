<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config;
use App\User;
use Exception;

trait SessionTrait {
	/**
	 *
	 * @return string
	 */
	public static function getBaseUri() {
		return (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' );
	}
	/**
	 *
	 * @return string
	 */
	public static function getRedirectUri() {
		return request ()->session ()->get ( 'redirect', '/' );
	}
	/**
	 *
	 * @return string $_userInfoFromRequest
	 */
	protected static function getUserInfoFromRequest() {
		if (! \App\Ezsell\Helper::$_userInfoFromRequest) {
			\App\Ezsell\Helper::$_userInfoFromRequest = static::param ( Config::SESSION_KEY );
		}
		return \App\Ezsell\Helper::$_userInfoFromRequest;
	}
	/**
	 *
	 * @param string $_userInfoFromRequest        	
	 * @return string $_userInfoFromRequest
	 */
	protected static function setUserInfoFromRequest($userInfoFromRequest) {
		\App\Ezsell\Helper::$_userInfoFromRequest = $userInfoFromRequest;
	}
	/**
	 *
	 * @return \App\User
	 */
	public static function getUser($throwExceptionIfNotFound = false) {
		if (! \App\Ezsell\Helper::$_user) {
			if (static::getToken ()) {
				try {
					// try to get user info by sending get user profile api to im
					$reponse = static::apiCallProfile ();
				} catch ( Exception $e ) {
				}
			}
			// if no user found, set it to guest
			if (! \App\Ezsell\Helper::$_user)
				\App\Ezsell\Helper::$_user = User::getGuest ();
		}
		return \App\Ezsell\Helper::$_user;
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected static function setUser(User $user) {
		\App\Ezsell\Helper::$_user = $user;
	}
}
