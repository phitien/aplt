<?php

namespace App\IM\Middleware;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;
use Closure;
use App\IM\Config\Config;
use App\IM\Response\Status;
use App\IM\Exceptions\TokenNotFound;
use App\IM\Utils;
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
			$user = Utils::user ( true );
		} catch ( TokenNotFound $e ) {
			return $this->jsonResponse ( 'token_not_found', null, Status::BadRequest );
		} catch ( UserNotFound $e ) {
			return $this->jsonResponse ( 'unauthorized', null, Status::Unauthorized );
		} catch ( TokenExpiredException $e ) {
			return $this->jsonResponse ( 'token_expired', null, Status::BadRequest );
		} catch ( TokenInvalidException $e ) {
			return $this->jsonResponse ( 'token_invalid', null, Status::BadRequest );
		} catch ( Exception $e ) {
			return $this->jsonResponse ( 'token_absent', null, Status::BadRequest );
		}
		
		$this->events->fire ( 'tymon.jwt.valid', $user );
		
		return $next ( $request );
	}
}
