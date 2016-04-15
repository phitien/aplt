<?php

namespace App\IM\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\IM\Utils;
use App\IM\Response\Status;
use JWTAuth;
use Exception;
use App\User;
use App\IM\Config;
use Route;
use Request;

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
		try {
			$this->_user = JWTAuth::authenticate ( JWTAuth::getToken () );
		} catch ( Exception $e ) {
			$this->_user = User::getGuest ();
		}
	}
	/**
	 *
	 * @return User
	 */
	protected function getUser() {
		return $this->_user;
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
		$middlewareActionMaps = Config::getMiddlewareActionMaps ();
		// echo $controller . "-" . $method . "-" . $requestType;
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
	 * Shortcut of Utils::jsonResponse
	 *
	 * @param unknown $message        	
	 * @param unknown $data        	
	 * @param unknown $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
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