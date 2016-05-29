<?php

namespace App\Media\Middleware;

use App\Shared\Middleware\Middleware as SharedMiddleware;
use App\Media\Traits\AllTrait;

abstract class Middleware extends SharedMiddleware {
	/**
	 * TRAITS
	 */
	use AllTrait;
}
