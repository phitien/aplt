<?php

namespace App\Platform\Controllers;

use App\Shared\Controllers\Controller as BaseController;
use App\Platform\Traits\AllTrait;

abstract class Controller extends BaseController {
	/**
	 * TRAITS
	 */
	use AllTrait;
}