<?php

namespace App\IM\Middleware;

use Closure;
use App\IM\Config;
use Illuminate\Http\Response;
use App\IM\Models\User;

class Authentication extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		$user = static::getUser ();
		if (static::getUser ()->isGuest ())
			return $this->jsonResponse ( 'unauthorized', null, Response::HTTP_UNAUTHORIZED );
		
		$this->events->fire ( 'tymon.jwt.valid', $user );
		
		return $next ( $request );
	}
}
