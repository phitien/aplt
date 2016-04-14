<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\Relations\Actions;
use App\IM\Config;
use App\IM\Models\Action;

trait ActionTrait
{
	/**
	 *
	 * @param array $code        	
	 * @return Action
	 */
	public function hasAction(array $codes) {
		$codes [count ( $codes )] = Config::ACTION_GOD_ACT;
		return $this->actions ()->whereIn ( 'actions.code', $codes )->first ();
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
