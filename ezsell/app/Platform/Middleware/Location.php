<?php

namespace App\Platform\Middleware;

use Closure;
use App\Platform\Config;
use App\Platform\Config\LocationMap;

class Location extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $actions        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		$location = static::getLocation ();
		if (! $location || $location == LocationMap::earth ()) {
			return $this->response ( view ( 'base', $this->getPageResponseData()->setType ( 'ChangeLocationPage' ) ) );
		}
		return $next ( $request );
	}
}
