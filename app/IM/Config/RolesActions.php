<?php

namespace App\IM\Config ;
 
use App\IM\Config\RolesActionsTrait;

class RolesActions {
	/**
	 * TRAITS
	 */
	use RolesActionsTrait;
	/**
	 *
	 * @param    string $role        	
	 * @return    array
	 */
	public static function getActions($role) {
		return isset ( static::$__maps [$role] ) ? static::$__maps [$role] : [ ];
	}
	/**
	 *
	 * @param    string $role        	
	 * @return    string
	 */
	public static function getStringActions($role) {
		return implode ( '|', static::getActions ( $role ) );
	}
	/**
	 *
	 * @param    string $role        	
	 * @param    string $action        	
	 * @return    bool
	 */
	public static function hasAction($role, $action) {
		return in_array ( $action, static::getActions ( $role ) );
	}
}