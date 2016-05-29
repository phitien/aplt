<?php

namespace App\IM\Middleware;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;
use Closure;
use App\IM\Config;
use Illuminate\Http\Response;
use App\IM\Exceptions\TokenNotFound;
use App\IM\Exceptions\UserNotFound;

class Authentication extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		try {
			$user = $this->user ( true );
		} catch ( TokenNotFound $e ) {
			return $this->jsonResponse ( 'token_not_found', null, Response::HTTP_BAD_REQUEST );
		} catch ( UserNotFound $e ) {
			return $this->jsonResponse ( 'unauthorized', null, Response::HTTP_UNAUTHORIZED );
		} catch ( TokenExpiredException $e ) {
			return $this->jsonResponse ( 'token_expired', null, Response::HTTP_BAD_REQUEST );
		} catch ( TokenInvalidException $e ) {
			return $this->jsonResponse ( 'token_invalid', null, Response::HTTP_BAD_REQUEST );
		} catch ( Exception $e ) {
			return $this->jsonResponse ( 'token_absent', null, Response::HTTP_BAD_REQUEST );
		}
		
		$this->events->fire ( 'tymon.jwt.valid', $user );
		
		return $next ( $request );
	}
}
