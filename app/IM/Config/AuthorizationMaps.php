<?php

namespace App\IM\Config;

use App\IM\Config\Config;

class AuthorizationMaps {
	const MAPS = [ 
			/**
			 * register/activate/deactivate/sendActivationCode
			 */
			'App\IM\Controllers\RegisterController' => [ 
					'register' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_CREATE_USER,
					'activate' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'deactivate' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'sendActivationCode' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER 
			],
			/**
			 * login/refresh/logout
			 */
			'App\IM\Controllers\AuthenticableController' => [ 
					'login' => Config::ACTION_GUEST_ACT,
					'refresh' => Config::ACTION_OWN_ACT,
					'logout' => Config::ACTION_OWN_ACT 
			],
			/**
			 * profile/updateProfile/updateExInfo
			 */
			'App\IM\Controllers\ProfileController' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
			/**
			 * followers/following/follow/accept/refuse
			 */
			'App\IM\Controllers\SocietyController' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
			'App\IM\Controllers\AccountController' => [ 
					'password' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'email' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'account' => Config::ACTION_OWN_ACT . '|' . Config::ACTION_MANAGER_ACT . '|' . Config::ACTION_ACCESS_USER,
					'forget' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_ACCESS_USER,
					'reset' => Config::ACTION_GUEST_ACT . '|' . Config::ACTION_ACCESS_USER 
			] 
	];
}