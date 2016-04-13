<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\Relations\Actions;

trait Action
{
	/**
	 * Return the actions that belong to the user.
	 */
	public function actions() {
		return new Actions ( $this );
	}
}
