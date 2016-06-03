<?php

namespace App\Platform\Middleware;

use Closure;
use App\Platform\Config;
use App\Platform\Traits\AllTrait;
use DateTime;
use App\Shared\Middleware\Prehandle as BasePrehandle;

class Prehandle extends BasePrehandle {
	/**
	 * TRAITS
	 */
	use AllTrait;
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
		return parent::handle ( $request, $next, $actions );
	}
}
