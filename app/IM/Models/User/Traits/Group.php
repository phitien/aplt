<?php

namespace App\IM\Models\User\Traits;

trait Group
{
	/**
	 * The groups that belong to the user.
	 */
	public function groups() {
		return $this->belongsToMany ( 'App\IM\Models\Group', 'user_group', 'user_id', 'group_id' )->where ( 'user_group.active', '=', 0 );
	}
}
