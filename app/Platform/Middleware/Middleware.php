<?php

namespace App\Platform\Middleware;

use App\Shared\Middleware\Middleware as SharedMiddleware;
use App\Platform\Traits\AllTrait;

abstract class Middleware extends SharedMiddleware {
	/**
	 * TRAITS
	 */
	use AllTrait;
}
