<?php

namespace App\IM\Middleware;

use App\IM\Utils;
use App\IM\Response\Status;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Closure;
use App\IM\Config;
use App\User;
use Exception;
use App\IM\Exceptions\TokenNotFound;

abstract class Middleware extends BaseMiddleware implements IMiddleware {
	protected $_user;
	public function getUser($request, $throwException = false) {
		$token = $this->auth->setRequest ( $request )->getToken ();
		if ($throwException) {
			if (! $token) {
				throw new TokenNotFound ( 'token_not_found' );
			} else {
				return $this->auth->authenticate ( $token );
			}
		} else {
			if (! $this->_user) {
				try {
					$this->_user = $this->auth->authenticate ( $token );
				} catch ( Exception $e ) {
					$this->_user = User::getGuest ();
				}
			}
			return $this->_user;
		}
	}
	/**
	 *
	 * @param unknown $request        	
	 * @param Closure $next        	
	 * @param unknown $action        	
	 */
	public function handle($request, Closure $next, $action = Config::ACTION_DEFAULT) {
		return $next ( $request );
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\IM\Response\IResponse::jsonResponse()
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
	}
}
