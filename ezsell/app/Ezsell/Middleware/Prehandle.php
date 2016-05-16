<?php

namespace App\Ezsell\Middleware;

use Closure;
use App\Ezsell\Config;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class Prehandle extends BaseMiddleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $actions        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		if ($url = request ()->get ( 'redirect' )) {
			if (strpos ( $url, '/login' ) === false) {
				$request->session ()->set ( 'redirect', $url );
			}
		}
		return $next ( $request );
	}
}
