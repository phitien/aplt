<?php

namespace App\Platform\Traits;

use App\Shared\Models\User;
use App\Platform\Helper;

trait SessionTrait {
	/**
	 *
	 * @return string
	 */
	public static function getRedirectUri() {
		return request ()->session ()->get ( 'redirect', '/' );
	}
	/**
	 *
	 * @return User
	 */
	public static function getUser() {
		$rs = static::apiCallProfile ();
		echo static::getToken ();
		echo $rs->getBody ();
		return Helper::$_user ? Helper::$_user : static::setUser ( User::getGuest () );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected static function setUser(User $user = NULL) {
		return Helper::$_user = $user;
	}
}
