<?php

namespace App\IM\Middleware;

use App\IM\Utils;
use App\IM\Response\Status;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Closure;
use App\IM\Config\Config;
use Illuminate\Http\Response;

abstract class Middleware extends BaseMiddleware implements IMiddleware {
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
	/**
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function response($status = Status::OK, array $headers = []) {
		return Utils::response ( $status, $headers );
	}
	/**
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return Response
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
	}
}
