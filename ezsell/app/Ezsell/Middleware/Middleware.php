<?php

namespace App\Ezsell\Middleware;

use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Closure;
use App\Ezsell\Config\Config;
use Illuminate\Http\Response;
use App\Ezsell\Traits\MailerTrait;
use App\Ezsell\Traits\UserTrait;
use App\Ezsell\Traits\ResponseTrait;
use App\Ezsell\Traits\EncoderTrait;
use App\Ezsell\Traits\RestfulTrait;

abstract class Middleware extends BaseMiddleware implements IMiddleware {
	/**
	 * TRAITS
	 */
	use EncoderTrait, MailerTrait, UserTrait, ResponseTrait, RestfulTrait;
	/**
	 *
	 * @var array
	 */
	protected $except = [ ];
	/**
	 * Determine if the request has a URI that should pass through CSRF verification.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return bool
	 */
	protected function shouldPassThrough($request) {
		foreach ( $this->except as $except ) {
			if ($except !== '/') {
				$except = trim ( $except, '/' );
			}
			if ($request->is ( $except )) {
				return true;
			}
		}
		return false;
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		if ($this->shouldPassThrough ( $request )) {
			return $next ( $request );
		} else {
			return $this->im_handle ( $request, $next, $actions );
		}
	}
}
