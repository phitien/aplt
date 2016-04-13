<?php

namespace App\IM;

use Hash;
use App\IM\Models\Role;
use App\IM\Models\Action;

class Configs {
	const FOLLOWER_REQUESTED = 0;
	const FOLLOWER_REQUEST_ACCEPTED = 1;
	const FOLLOWER_REQUEST_REFUSED = 2;
	public static function getCoreActions() {
		return [ 
				1 => [ 
						'code' => 'ALL',
						'name' => 'All' 
				],
				2 => [ 
						'code' => 'CREATE',
						'name' => 'Create/Register' 
				],
				3 => [ 
						'code' => 'UPDATE',
						'name' => 'Update Profile' 
				],
				4 => [ 
						'code' => 'ACCESS',
						'name' => 'Change Password/Change Email/Change Account' 
				],
				5 => [ 
						'code' => 'DELETE',
						'name' => 'Self Activate/Self Deactivate' 
				],
				6 => [ 
						'code' => 'VIEW_FOLLOWERS',
						'name' => 'View followers' 
				],
				7 => [ 
						'code' => 'VIEW_FOLLOWING',
						'name' => 'View followers' 
				],
				8 => [ 
						'code' => 'READ',
						'name' => 'Read' 
				],
				9 => [ 
						'code' => 'POST',
						'name' => 'Post' 
				],
				10 => [ 
						'code' => 'TAG',
						'name' => 'Tag' 
				],
				11 => [ 
						'code' => 'SHARE',
						'name' => 'Share' 
				],
				12 => [ 
						'code' => 'EDIT',
						'name' => 'Edit' 
				],
				13 => [ 
						'code' => 'REMOVE',
						'name' => 'Remove' 
				],
				14 => [ 
						'code' => 'COMMENT',
						'name' => 'Comment' 
				],
				15 => [ 
						'code' => 'LIKE',
						'name' => 'Like' 
				],
				16 => [ 
						'code' => 'FOLLOW',
						'name' => 'Follow' 
				],
				17 => [ 
						'code' => 'CREATE_USER',
						'name' => 'Create User' 
				],
				18 => [ 
						'code' => 'UPDATE_USER',
						'name' => 'Update profile of other User' 
				],
				19 => [ 
						'code' => 'ACCESS_USER',
						'name' => 'Change (Password/Email/Account/Roles) of other User' 
				],
				20 => [ 
						'code' => 'DELETE_USER',
						'name' => 'Activate/Deactivate other User' 
				],
				21 => [ 
						'code' => 'VIEW_USER_DETAIL',
						'name' => 'View profile of other User' 
				],
				22 => [ 
						'code' => 'VIEW_USER_LIST',
						'name' => 'View Users List' 
				],
				23 => [ 
						'code' => 'CREATE_ROLE',
						'name' => 'Create Role' 
				],
				24 => [ 
						'code' => 'UPDATE_ROLE',
						'name' => 'Update Role' 
				],
				25 => [ 
						'code' => 'DELETE_ROLE',
						'name' => 'Delete Role' 
				],
				26 => [ 
						'code' => 'VIEW_ROLE_DETAIL',
						'name' => 'View Role Detail' 
				],
				27 => [ 
						'code' => 'VIEW_ROLE_LIST',
						'name' => 'View Roles list' 
				],
				28 => [ 
						'code' => 'CREATE_ACTION',
						'name' => 'Create Action' 
				],
				29 => [ 
						'code' => 'UPDATE_ACTION',
						'name' => 'Update Action' 
				],
				30 => [ 
						'code' => 'DELETE_ACTION',
						'name' => 'Delete Action' 
				],
				31 => [ 
						'code' => 'VIEW_ACTION_DETAIL',
						'name' => 'View Action Detail' 
				],
				32 => [ 
						'code' => 'VIEW_ACTION_LIST',
						'name' => 'View Actions list' 
				] 
		];
	}
	const SUPREME = 'SUPREME';
	const MANAGER = 'MANAGER';
	const USER = 'USER';
	const GUEST = 'GUEST';
	public static function getCoreRoles() {
		return [ 
				1 => [ 
						'code' => static::SUPREME,
						'name' => 'Supreme' 
				],
				2 => [ 
						'code' => static::MANAGER,
						'name' => 'Manager' 
				],
				3 => [ 
						'code' => static::USER,
						'name' => 'User' 
				],
				4 => [ 
						'code' => static::GUEST,
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
			case static::SUPREME :
				$str = '1';
				return explode ( ',', $str );
			case static::MANAGER :
				$str = '2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,19,20,22,23,24,25,26,27,28,29,30,31,32';
				return explode ( ',', $str );
			case static::USER :
				$str = '2,3,4,5,6,7,8,9,10,11,12,13,14,15,16';
				return explode ( ',', $str );
			case static::GUEST :
			default :
				$str = '6,7,8';
				return explode ( ',', $str );
		}
	}
	public static function canAddAction(Role $role, Action $action) {
		$existance = $role->actions ()->where ( 'action_id', '=', $action->id )->first ();
		if ($existance) // already added
			return false;
		else if (in_array ( $action->id, Configs::getRoleActions ( $role ) )) // not added but in the default config
			return true;
		else { // not added and not in the default config
			return true;
		}
	}
	public static function canRemoveAction(Role $role, Action $action) {
		$existance = $role->actions ()->where ( 'action_id', '=', $action->id )->first ();
		if (! $existance) // not existing
			return false;
		else if (in_array ( $action->id, Configs::getRoleActions ( $role ) )) // exists and in the default config
			return false;
		else { // exists and not in the default config
			return true;
		}
	}
}