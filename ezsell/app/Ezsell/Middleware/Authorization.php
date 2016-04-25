<?php

namespace App\Ezsell\Middleware;

use Closure;
use App\Ezsell\Config\Config;

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
		if (! $action)
			return $this->jsonResponse ( 'unauthorised', null, Response::HTTP_UNAUTHORIZED );
		return $next ( $request );
	}
}
