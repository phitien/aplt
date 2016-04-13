<?php

namespace App\IM\Models\User\Traits;

trait Role
{
	public static function createSuperadmin($attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( 1 );
		// $user->roles ()->attach ( 4 );
		return $user;
	}
	public static function createManager($attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( 2 );
		// $user->roles ()->attach ( 4 );
		return $user;
	}
	public static function createUser($attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( 3 );
		// $user->roles ()->attach ( 4 );
		return $user;
	}
	/**
	 * Return the roles that belong to the user.
	 */
	public function roles() {
		return $this->belongsToMany ( 'App\IM\Models\Role', 'user_role', 'user_id', 'role_id' );
	}
}
