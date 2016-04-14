<?php

namespace App\IM\Middleware;

use App\IM\Config;
use Closure;

class Registration extends Middleware {
	public function handle($request, Closure $next, $action = Config::ACTION_DEFAULT) {
		return $next ( $request );
	}
}
