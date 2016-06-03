<?php

namespace App\IM\Traits;

use JWTAuth;
use App\IM\Models\User;
use Exception;

trait UserTrait
{
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
