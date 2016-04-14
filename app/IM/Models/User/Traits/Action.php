<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\Relations\Actions;

trait Action
{
	/**
	 *
	 * @param unknown $code        	
	 */
	public function hasAction($code) {
		return $this->actions ()->where ( 'actions.code', '=', $code )->first ();
	}
	/**
	 * Return the actions that belong to the user.
	 */
	public function actions() {
		return new Actions ( $this );
	}
}
