<?php

namespace App\Media\Controllers;

use App\Shared\Controllers\Controller as SharedController;
use App\Media\Traits\AllTrait;

abstract class Controller extends SharedController {
	/**
	 * Traits
	 */
	use AllTrait;
}