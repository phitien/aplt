<?php

namespace App\Platform\Controllers;

use App\Platform\Controllers\Traits\AccountTrait;
use App\Platform\Controllers\Traits\RegisterTrait;
use App\Platform\Controllers\Traits\ActivateTrait;
use App\Platform\Controllers\Traits\DeactivateTrait;
use App\Platform\Controllers\Traits\ProfileTrait;
use App\Platform\Controllers\Traits\SocietyTrait;
use App\Platform\Controllers\Traits\LoginTrait;

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
