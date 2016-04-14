<?php

namespace App\IM\Middleware;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;
use Closure;
use App\IM\Config;

class AuthenticationMiddleware extends Middleware {
	/**
	 *
	 * @param unknown $request        	
	 * @param \Closure $next        	
	 */
	public function handle($request, Closure $next, $action = Config::ACTION_DEFAULT) {
		if (! $token = $this->auth->setRequest ( $request )->getToken ()) {
			return $this->jsonResponse ( 'token_not_provided', null, 400 );
		}
		
		try {
			$user = $this->auth->authenticate ( $token );
		} catch ( TokenExpiredException $e ) {
			return $this->jsonResponse ( 'token_expired', null, $e->getStatusCode () );
		} catch ( TokenInvalidException $e ) {
			return $this->jsonResponse ( 'token_invalid', null, $e->getStatusCode () );
		} catch ( Exception $e ) {
			return $this->jsonResponse ( 'token_absent', null, $e->getStatusCode () );
		}
		
		if (! $user) {
			return $this->jsonResponse ( 'user_not_found', null, 404 );
		}
		
		$this->events->fire ( 'tymon.jwt.valid', $user );
		
		return $next ( $request );
	}
}
