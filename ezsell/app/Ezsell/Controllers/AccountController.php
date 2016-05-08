<?php

namespace App\Ezsell\Controllers;

use App\Ezsell\Controllers\Traits\AccountTrait;
use App\Ezsell\Controllers\Traits\RegisterTrait;
use App\Ezsell\Controllers\Traits\ActivateTrait;
use App\Ezsell\Controllers\Traits\DeactivateTrait;
use App\Ezsell\Controllers\Traits\ProfileTrait;
use App\Ezsell\Controllers\Traits\SocietyTrait;

class AccountController extends BaseController {
	/**
	 * Traits
	 */
	use AccountTrait, RegisterTrait, ActivateTrait, DeactivateTrait, ProfileTrait, SocietyTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ ] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ ] 
	];
}
