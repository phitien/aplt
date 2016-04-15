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
use Symfony\Component\HttpFoundation\Cookie;

abstract class Middleware extends BaseMiddleware implements IMiddleware {
	/**
	 *
	 * @var array
	 */
	protected $except = [ ];
	/**
	 *
	 * @var User $_user
	 */
	protected $_user;
	/**
	 *
	 * @var string
	 */
	protected $_token;
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
	 * Add the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param \Illuminate\Http\Response $response        	
	 * @return \Illuminate\Http\Response
	 */
	protected function addCookieToResponse($request, $response) {
		$config = config ( 'session' );
		$response->headers->setCookie ( new Cookie ( 'IM-TOKEN', $this->getToken ( $request ), time () + 60 * 120, $config ['path'], $config ['domain'], $config ['secure'], false ) );
		return $response;
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		return $this->addCookieToResponse ( $request, $next ( $request ) );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return string $this->_token
	 */
	protected function getToken($request) {
		if (! $this->_token)
			$this->_token = $this->auth->setRequest ( $request )->getToken ();
		return $this->_token;
	}
	/**
	 *
	 * @return User
	 */
	public function getUser($request, $throwException = false) {
		$token = $this->getToken ( $request );
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
	 * @return \Illuminate\Http\Response
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
	}
}
