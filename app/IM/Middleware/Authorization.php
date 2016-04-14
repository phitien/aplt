<?php

namespace App\IM\Middleware;

use Closure;
use App\IM\Config;
use App\IM\Response\Status;

class Authorization extends Middleware {
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\IM\Middleware\Middleware::handle()
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		$user = $this->getUser ( $request );

		$action = $user->hasAction ( explode ( '|', $actions ) );
		if (! $action)
			return $this->jsonResponse ( 'not_authorised', null, Status::Unauthorized );
		
		return parent::handle ( $request, $next, $actions );
	}
}
