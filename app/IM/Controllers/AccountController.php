<?php

namespace App\IM\Controllers;

use App\IM\Controllers\Traits\RegisterTrait;
use App\IM\Controllers\Traits\ActivateTrait;
use App\IM\Controllers\Traits\DeactivateTrait;
use App\IM\Controllers\Traits\ProfileTrait;
use App\IM\Controllers\Traits\SocietyTrait;
use App\IM\Controllers\Traits\AccountTrait;

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
