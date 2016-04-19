<?php

namespace App\Ezsell\Controllers;

use App\Ezsell\Controllers\Traits\AccountTrait;
use App\Ezsell\Controllers\Traits\RegisterTrait;
use App\Ezsell\Controllers\Traits\ActivateTrait;
use App\Ezsell\Controllers\Traits\DeactivateTrait;
use App\Ezsell\Controllers\Traits\ProfileTrait;
use App\Ezsell\Controllers\Traits\SocietyTrait;

class AccountController extends AuthenticableController {
	/**
	 * Traits
	 */
	use AccountTrait, RegisterTrait, ActivateTrait, DeactivateTrait, ProfileTrait, SocietyTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'login',
					'code',
					'register',
					'activate' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ 
					'login',
					'code',
					'register',
					'activate' 
			] 
	];
}