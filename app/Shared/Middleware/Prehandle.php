<?php

namespace App\Shared\Middleware;

use Closure;
use App\Shared\Config;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Log;
use Illuminate\Http\RedirectResponse;

class Prehandle extends BaseMiddleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $actions        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		Log::error ( 'Before	: ' . static::getToken () );
		$response = $next ( $request );
		request ()->session ()->set ( Config::TOKEN_KEY, static::getToken () );
		Log::error ( 'After		: ' . static::getToken () );
		Log::error ( 'After		: ' . request ()->session ()->get ( Config::TOKEN_KEY ) );
		if ($response instanceof RedirectResponse) {
		} else {
			$response = response ( $response );
		}
		$response = static::addHeaders ( $response );
		
		return $response;
	}
}
