<?php

namespace App\Platform\Middleware;

use Closure;
use App\Platform\Config;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use App\Platform\Traits\AllTrait;
use DateTime;

class Prehandle extends BaseMiddleware {
	/**
	 * TRAITS
	 */
	use AllTrait;
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $actions        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		// Set request time variable in session
		if ($request->has ( Config::MODE ) || ! $request->ajax ()) {
			$request->session ()->set ( Config::REQUEST_TIME, (new DateTime ())->format ( Config::DATETIME_DB_FORMAT ) );
		}
		// Set redirect variable in session
		if ($url = request ()->get ( 'redirect' )) {
			if (strpos ( $url, '/login' ) === false) {
				$request->session ()->set ( 'redirect', $url );
			}
		}
		return $next ( $request );
	}
}
