<?php

namespace App\IM\Models\User\Traits;

trait Role
{
	/**
	 * The roles that belong to the user.
	 */
	public function roles() {
		return $this->belongsToMany ( 'App\IM\Models\Role', 'user_role', 'user_id', 'role_id' );
	}
}
