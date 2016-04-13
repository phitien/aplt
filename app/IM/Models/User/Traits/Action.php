<?php

namespace App\IM\Models\User\Traits;

trait Action
{
	/**
	 * The roles that belong to the user.
	 */
	public function actions() {
		return $this->belongsToMany ( 'App\IM\Models\Action', 'user_action', 'user_id', 'action_id' );
	}
}
