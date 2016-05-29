<?php

namespace App\IM\Middleware;

use App\IM\Traits\AllTrait;
use App\Shared\Middleware\Middleware as SharedMiddleware;

abstract class Middleware extends SharedMiddleware {
	/**
	 * TRAITS
	 */
	use AllTrait;
}
