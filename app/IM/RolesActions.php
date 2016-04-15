<?php

namespace App\IM;

class RolesActions {
	/**
	 * Constants
	 */
	/**
	 * Private static variables
	 */
	/**
	 * Protected static variables
	 */
	/**
	 * Public static variables
	 */
 	public static $maps = [ 
		'SUPREME' => [
			'GOD_ACT', 
		],
		'MANAGER' => [
			'MANAGER_ACT', 
			'OWN_ACT', 
			'CREATE_USER', 
			'ACCESS_USER', 
			'CREATE_ROLE', 
			'ACCESS_ROLE', 
			'CREATE_ACTION', 
			'ACCESS_ACTION', 
		],
		'USER' => [
			'OWN_ACT', 
		],
		'GUEST' => [
			'GUEST_ACT', 
		],
 
	];
 	/**
	 * Private variables
	 */
	/**
	 * Protected variables
	 */
	/**
	 * Public variables
	 */
	/**
	 * Others (Functions...)
	 */
	/**
	 *
	 * @param  string $role        	
	 * @return  array
	 */
	public static function getActions($role) {
		return isset ( static::$maps [$role] ) ? static::$maps [$role] : [ ];
	}
	/**
	 *
	 * @param  string $role        	
	 * @return  string
	 */
	public static function getStringActions($role) {
		return implode ( '|', static::getActions ( $role ) );
	}
	/**
	 *
	 * @param  string $role        	
	 * @param  string $action        	
	 * @return  bool
	 */
	public static function hasAction($role, $action) {
		return in_array ( $action, static::getActions ( $role ) );
	}
	
}