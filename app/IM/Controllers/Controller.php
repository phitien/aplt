<?php

namespace App\IM\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\IM\Utils;
use JWTAuth;
use Exception;
use App\User;
use App\IM\Config\Config;
use Route;
use Request;
use App\IM\Config\AuthorizationMaps;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

abstract class Controller extends BaseController implements IController {
	/**
	 *
	 * @var string
	 */
	protected $_middleware_action = Config::ACTION_GUEST_ACT;
	/**
	 *
	 * @var array
	 */
	protected $_authenticationMiddlewareOptions = [ ];
	/**
	 *
	 * @var array
	 */
	protected $_authorizationMiddlewareOptions = [ ];
	/**
	 *
	 * @var User
	 */
	protected $_user;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->_middleware_action = $this->getMiddlewareAction ();
		$this->setupMiddlewares ();
		$this->setupUser ();
	}
	/**
	 *
	 * @return void
	 */
	protected function setupUser() {
		$this->_user = Utils::user ();
	}
	/**
	 *
	 * @return void
	 */
	protected function setupMiddlewares() {
		$this->middleware ( "im.authentication:{$this->_middleware_action}", $this->getAuthenticationMiddlewareOptions () );
		$this->middleware ( "im.authorization:{$this->_middleware_action}", $this->getAuthorizationMiddlewareOptions () );
	}
	/**
	 *
	 * @return string|string|string[]|string
	 */
	protected function getMiddlewareAction() {
		$arr = explode ( '@', Route::getCurrentRoute ()->getActionName () );
		$controller = $arr [0];
		$method = $arr [1];
		$requestType = Request::method ();
		$middlewareActionMaps = AuthorizationMaps::MAPS;
		try {
			return ( string ) $middlewareActionMaps [$controller] [$method] [$requestType];
		} catch ( Exception $e ) {
			try {
				return ( string ) $middlewareActionMaps [$controller] [$method];
			} catch ( Exception $e ) {
				try {
					return ( string ) $middlewareActionMaps [$controller];
				} catch ( Exception $e ) {
				}
			}
		}
		return Config::ACTION_GUEST_ACT;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\IM\Controllers\IController::getAuthenticationMiddlewareOptions()
	 */
	public function getAuthenticationMiddlewareOptions() {
		return $this->_authenticationMiddlewareOptions;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\IM\Controllers\IController::getAuthorizationMiddlewareOptions()
	 */
	public function getAuthorizationMiddlewareOptions() {
		return $this->_authorizationMiddlewareOptions;
	}
	/**
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function response($status = Response::HTTP_OK, array $headers = []) {
		return Utils::setResponseCookieToken ( Utils::response ( $status, $headers ), JWTAuth::getToken () );
	}
	/**
	 * Shortcut of Utils::jsonResponse
	 *
	 * @param unknown $message        	
	 * @param unknown $data        	
	 * @param unknown $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function jsonResponse($message = null, $data = null, $status = Response::HTTP_OK, array $headers = []) {
		return Utils::setResponseCookieToken ( Utils::jsonResponse ( $message, $data, $status, $headers ), JWTAuth::getToken () );
	}
	/**
	 *
	 * @param Response $response        	
	 * @param string $message        	
	 * @param string $data        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function updateJsonResponse(JsonResponse $response, $message = null, $data = null) {
		return Utils::updateJsonResponse ( $response, $message, $data );
	}
	/**
	 * Shortcut of Utils::encode
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected function encode(string $str) {
		return Utils::encode ( $str );
	}
}