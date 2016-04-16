<?php

namespace App\IM\Middleware;

use Closure;
use App\IM\Config\Config;
use App\IM\Response\Status;
use App\IM\Utils;

class Authorization extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		$action = Utils::user ()->hasAction ( explode ( '|', $actions ) );
		if (! $action)
			return $this->jsonResponse ( 'unauthorised', null, Status::Unauthorized );
		return $next ( $request );
	}
}
