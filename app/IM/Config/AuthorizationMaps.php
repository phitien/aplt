<?php

namespace App\IM\Config;

use App\IM\Config\Config;

class AuthorizationMaps {
	const MAPS = [ 
			/**
			 * profile/updateProfile/updateExInfo
			 */
			'App\IM\Controllers\ProfileController' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
			/**
			 * followers/following/follow/accept/refuse
			 */
			'App\IM\Controllers\SocietyController' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
			/**
			 * login/logout
			 * register/activate/deactivate/code
			 * password/email/account/forget
			 */
			'App\IM\Controllers\AccountController' => [ 
					'login' => Config::ACTION_GUEST_ACT,
					'logout' => Config::ACTION_OWN_ACT,
					'register' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_CREATE_USER,
					'activate' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'code' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'deactivate' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'password' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'email' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'account' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'forget' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_ACCESS_USER,
					'reset' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_ACCESS_USER,
					'profile' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'profilex' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'followers' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'following' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'follow' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'accept' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'refuse' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER 
			] 
	];
}