<?php

namespace App\IM\Middleware;

use Tymon\JWTAuth\Middleware\GetUserFromToken;
use App\IM\Response\Status;
use App\IM\Utils;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class AuthMiddleware extends GetUserFromToken implements IMiddleware {
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\IM\Response\IResponse::jsonResponse()
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Tymon\JWTAuth\Middleware\GetUserFromToken::handle()
	 */
	public function handle($request, \Closure $next) {
		if (! $token = $this->auth->setRequest ( $request )->getToken ()) {
			return $this->jsonResponse ( 'token_not_provided', null, 400 );
		}
		
		try {
			$user = $this->auth->authenticate ( $token );
		} catch ( TokenExpiredException $e ) {
			return $this->jsonResponse ( 'token_expired', null, $e->getStatusCode () );
		} catch ( TokenInvalidException $e ) {
			return $this->jsonResponse ( 'token_invalid', null, $e->getStatusCode () );
		} catch ( JWTException $e ) {
			return $this->jsonResponse ( 'token_absent', null, $e->getStatusCode () );
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