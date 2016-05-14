<?php

namespace App\Ezsell\Controllers;

use App\Ezsell\Controllers\Traits\AccountTrait;
use App\Ezsell\Controllers\Traits\RegisterTrait;
use App\Ezsell\Controllers\Traits\ActivateTrait;
use App\Ezsell\Controllers\Traits\DeactivateTrait;
use App\Ezsell\Controllers\Traits\ProfileTrait;
use App\Ezsell\Controllers\Traits\SocietyTrait;
use App\Ezsell\Controllers\Traits\LoginTrait;

class AccountController extends Controller {
	/**
	 * Traits
	 */
	use LoginTrait, AccountTrait, RegisterTrait, ActivateTrait, DeactivateTrait, ProfileTrait, SocietyTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'code',
					'login',
					'logout',
					'register',
					'activate' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ ] 
	];
}
