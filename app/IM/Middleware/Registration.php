<?php

namespace App\IM\Middleware;

class Registration extends Middleware {
	public function handle($request, \Closure $next) {
		return $next ( $request );
	}
}
