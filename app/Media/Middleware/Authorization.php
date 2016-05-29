<?php

namespace App\Media\Middleware;

use Closure;
use App\Media\Config;

class Authorization extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $actions        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		$action = static::getUser ()->hasAction ( explode ( '|', $actions ) );
		if (! $action) {
			$this->pumpUnauthorized ();
		}
		return $next ( $request );
	}
}
