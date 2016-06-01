<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\Relations\Actions;
use App\IM\Models\Action;
use App\Shared\Config\RolesActions;

trait ActionTrait
{
	/**
	 *
	 * @param array $code        	
	 * @return Action
	 */
	public function hasAction(array $codes) {
		$roles = $this->roles;
		foreach ( $roles as $role ) {
			foreach ( $codes as $action ) {
				if (RolesActions::hasAction ( $role->code, $action ))
					return true;
			}
		}
		return false;
	}
	/**
	 * Return the actions that belong to the user.
	 *
	 * @return Actions
	 */
	public function actions() {
		return (new Actions ( $this ));
	}
}
