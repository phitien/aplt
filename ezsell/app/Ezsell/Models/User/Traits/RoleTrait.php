<?php

namespace App\Ezsell\Models\User\Traits;

use App\User;

trait RoleTrait
{
	/**
	 *
	 * @var User
	 */
	protected static $_instanceGuest = null;
	/**
	 *
	 * @return User guest
	 */
	public static function getGuest() {
		if (null === static::$_instanceGuest) {
			static::$_instanceGuest = new User ( [ 
					'active' => 1,
					'id' => - 1 
			] );
		}
		return static::$_instanceGuest;
	}
	/**
	 * check user is guest or not
	 *
	 * @return boolean
	 */
	public function isGuest() {
		return $this->id < 0;
	}
	/**
	 *
	 * @param array $action        	
	 * @return bool
	 */
	public function hasAction(array $action) {
		return true;
	}
}
