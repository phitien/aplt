<?php

namespace App\IM\Middleware;

use Closure;
use App\IM\Config;

class Authorization extends Middleware {
	public function handle($request, Closure $next, $action = Config::ACTION_DEFAULT) {
		return $next ( $request );
	}
}
