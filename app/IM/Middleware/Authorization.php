<?php

namespace App\IM\Middleware;

use Closure;
use App\IM\Config;

class Authorization extends Middleware {
	public function handle($request, Closure $next, $action = Config::ACTION_DEFAULT) {
		$user = $this->getUser ( $request );
		return $this->jsonResponse ( '', $user->hasAction ( $action ) );
		return $next ( $request );
	}
}
