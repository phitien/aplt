<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\Relations\Roles;
use App\User;

trait Role
{
	/**
	 *
	 * @return Guest
	 */
	private static $_instanceGuest = null;
	public static function getGuest() {
		if (null === static::$_instanceGuest) {
			static::$_instanceGuest = new User ( [ 
					'active' => 1 
			] );
		}
		return static::$_instanceGuest;
	}
	/**
	 * check user is guest or not
	 */
	public function isGuest() {
		return $this == static::getGuest ();
	}
	/**
	 * Create Superadmin
	 *
	 * @param unknown $attributes        	
	 */
	public static function createSuperadmin($attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( 1 );
		return $user;
	}
	/**
	 * Create manager
	 *
	 * @param unknown $attributes        	
	 */
	public static function createManager($attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( 2 );
		return $user;
	}
	/**
	 * Create normal user
	 *
	 * @param unknown $attributes        	
	 */
	public static function createUser($attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( 3 );
		return $user;
	}
	/**
	 * Return the roles that belong to the user.
	 */
	public function roles() {
		return (new Roles ( $this, $this->getBelongsToManyCaller () ));
	}
}
