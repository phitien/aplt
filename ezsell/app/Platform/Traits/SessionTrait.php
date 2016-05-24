<?php

namespace App\Platform\Traits;

use App\Platform\Config;
use App\User;
use Exception;
use App\Platform\Helper;
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
		if (! Helper::$_userInfoFromRequest) {
			Helper::$_userInfoFromRequest = static::param ( Config::SESSION_KEY );
		}
		return Helper::$_userInfoFromRequest;
	}
	/**
	 *
	 * @param string $_userInfoFromRequest        	
	 * @return string $_userInfoFromRequest
	 */
	protected static function setUserInfoFromRequest($userInfoFromRequest) {
		Helper::$_userInfoFromRequest = $userInfoFromRequest;
	}
	/**
	 *
	 * @return \App\User
	 */
	public static function getUser($throwExceptionIfNotFound = false) {
		if (! Helper::$_user) {
			if (static::getToken ()) {
				try {
					// try to get user info by sending get user profile api to im
					$reponse = static::apiCallProfile ();
				} catch ( Exception $e ) {
				}
			}
			// if no user found, set it to guest
			if (! Helper::$_user)
				Helper::$_user = User::getGuest ();
		}
		return Helper::$_user;
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected static function setUser(User $user) {
		Helper::$_user = $user;
	}
}
