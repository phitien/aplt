<?php

namespace App\IM;

use Hash;
use App\IM\Models\Role;
use App\IM\Models\Action;
use Route;
use Request;
use Exception;

class Config {
	/**
	 *
	 * @var unknown
	 */
	const FOLLOWER_REQUESTED = 0;
	const FOLLOWER_REQUEST_ACCEPTED = 1;
	const FOLLOWER_REQUEST_REFUSED = 2;
	//
	const ACTION_DEFAULT = 'UNDEFINED';
	const ACTION_SUPREME = 'ALL';
	//
	const ROLE_SUPREME = 'SUPREME';
	const ROLE_MANAGER = 'MANAGER';
	const ROLE_USER = 'USER';
	const ROLE_GUEST = 'GUEST';
	/**
	 */
	public static function getMiddlewareAction() {
		$arr = explode ( '@', Route::getCurrentRoute ()->getActionName () );
		$controller = $arr [0];
		$method = $arr [1];
		$requestType = Request::method ();
		try {
			return static::MIDDLEWARE_ACTION_MAPS [$controller] [$method] [$requestType];
		} catch ( Exception $e ) {
			try {
				return static::MIDDLEWARE_ACTION_MAPS [$controller] [$method];
			} catch ( Exception $e ) {
			}
		}
		return static::ACTION_DEFAULT;
	}
	const MIDDLEWARE_ACTION_MAPS = [ 
			'App\IM\Controllers\RegisterController' => [ 
					'register' => [ 
							'POST' => 'CREATE' 
					],
					'activate' => 'UPDATE',
					'sendActivationCode' => 'READ' 
			] 
	];
	/**
	 */
	public static function getCoreActions() {
		return [ 
				1 => [ 
						'code' => static::ACTION_SUPREME,
						'name' => 'All' 
				],
				2 => [ 
						'code' => static::ACTION_DEFAULT,
						'name' => 'Undefined (Default)' 
				],
				3 => [ 
						'code' => 'CREATE',
						'name' => 'Create/Register' 
				],
				4 => [ 
						'code' => 'UPDATE',
						'name' => 'Update Profile' 
				],
				5 => [ 
						'code' => 'ACCESS',
						'name' => 'Change Password/Change Email/Change Account' 
				],
				6 => [ 
						'code' => 'DELETE',
						'name' => 'Self Activate/Self Deactivate' 
				],
				7 => [ 
						'code' => 'VIEW_FOLLOWERS',
						'name' => 'View followers' 
				],
				8 => [ 
						'code' => 'VIEW_FOLLOWING',
						'name' => 'View followers' 
				],
				9 => [ 
						'code' => 'READ',
						'name' => 'Read' 
				],
				10 => [ 
						'code' => 'POST',
						'name' => 'Post' 
				],
				11 => [ 
						'code' => 'TAG',
						'name' => 'Tag' 
				],
				12 => [ 
						'code' => 'SHARE',
						'name' => 'Share' 
				],
				13 => [ 
						'code' => 'EDIT',
						'name' => 'Edit' 
				],
				14 => [ 
						'code' => 'REMOVE',
						'name' => 'Remove' 
				],
				15 => [ 
						'code' => 'COMMENT',
						'name' => 'Comment' 
				],
				16 => [ 
						'code' => 'LIKE',
						'name' => 'Like' 
				],
				17 => [ 
						'code' => 'FOLLOW',
						'name' => 'Follow' 
				],
				18 => [ 
						'code' => 'CREATE_USER',
						'name' => 'Create User' 
				],
				19 => [ 
						'code' => 'UPDATE_USER',
						'name' => 'Update profile of other User' 
				],
				20 => [ 
						'code' => 'ACCESS_USER',
						'name' => 'Change (Password/Email/Account/Roles) of other User' 
				],
				21 => [ 
						'code' => 'DELETE_USER',
						'name' => 'Activate/Deactivate other User' 
				],
				22 => [ 
						'code' => 'VIEW_USER_DETAIL',
						'name' => 'View profile of other User' 
				],
				23 => [ 
						'code' => 'VIEW_USER_LIST',
						'name' => 'View Users List' 
				],
				24 => [ 
						'code' => 'CREATE_ROLE',
						'name' => 'Create Role' 
				],
				25 => [ 
						'code' => 'UPDATE_ROLE',
						'name' => 'Update Role' 
				],
				26 => [ 
						'code' => 'DELETE_ROLE',
						'name' => 'Delete Role' 
				],
				27 => [ 
						'code' => 'VIEW_ROLE_DETAIL',
						'name' => 'View Role Detail' 
				],
				28 => [ 
						'code' => 'VIEW_ROLE_LIST',
						'name' => 'View Roles list' 
				],
				29 => [ 
						'code' => 'CREATE_ACTION',
						'name' => 'Create Action' 
				],
				30 => [ 
						'code' => 'UPDATE_ACTION',
						'name' => 'Update Action' 
				],
				31 => [ 
						'code' => 'DELETE_ACTION',
						'name' => 'Delete Action' 
				],
				32 => [ 
						'code' => 'VIEW_ACTION_DETAIL',
						'name' => 'View Action Detail' 
				],
				33 => [ 
						'code' => 'VIEW_ACTION_LIST',
						'name' => 'View Actions list' 
				] 
		];
	}
	public static function getCoreRoles() {
		return [ 
				1 => [ 
						'code' => static::ROLE_SUPREME,
						'name' => 'Supreme' 
				],
				2 => [ 
						'code' => static::ROLE_MANAGER,
						'name' => 'Manager' 
				],
				3 => [ 
						'code' => static::ROLE_USER,
						'name' => 'User' 
				],
				4 => [ 
						'code' => static::ROLE_GUEST,
						'name' => 'Guest' 
				] 
		];
	}
	public static function getSuperadminData() {
		return [ 
				'name' => 'superadmin',
				'email' => 'superadmin@gmail.com',
				'password' => Hash::make ( 'superadmin' ) 
		];
	}
	public static function getManagerData() {
		return [ 
				'name' => 'manager',
				'email' => 'manager@gmail.com',
				'password' => Hash::make ( 'manager' ) 
		];
	}
	public static function getUserData() {
		return [ 
				'name' => 'user',
				'email' => 'user@gmail.com',
				'password' => Hash::make ( 'user12' ) 
		];
	}
	public static function getRoleActions(Role $role) {
		switch ($role->code) {
			case static::ROLE_SUPREME :
				$str = '1';
				return explode ( ',', $str );
			case static::ROLE_MANAGER :
				$str = '2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,20,21,23,24,25,26,27,28,29,30,31,32,33';
				return explode ( ',', $str );
			case static::ROLE_USER :
				$str = '2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17';
				return explode ( ',', $str );
			case static::ROLE_GUEST :
			default :
				$str = '2,3,7,8,9';
				return explode ( ',', $str );
		}
	}
	public static function canAddAction(Role $role, Action $action = null) {
		if (! $action)
			return false;
		$existance = $role->actions ()->where ( 'action_id', '=', $action->id )->first ();
		if ($existance) // already added
			return false;
		else if (in_array ( $action->id, Config::getRoleActions ( $role ) )) // not added but in the default config
			return true;
		else { // not added and not in the default config
			return true;
		}
	}
	public static function canRemoveAction(Role $role, Action $action = null) {
		if (! $action)
			return false;
		$existance = $role->actions ()->where ( 'action_id', '=', $action->id )->first ();
		if (! $existance) // not existing
			return false;
		else if (in_array ( $action->id, Config::getRoleActions ( $role ) )) // exists and in the default config
			return false;
		else { // exists and not in the default config
			return true;
		}
	}
}