<?php

namespace App\Ezsell\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Exception;
use App\Ezsell\Config\Config;
use Route;
use Request;
use App\Ezsell\Config\AuthorizationMaps;
use App\Ezsell\Traits\MailerTrait;
use App\Ezsell\Traits\ResponseTrait;
use App\Ezsell\Traits\UtilTrait;
use App\Ezsell\Traits\RestfulTrait;
use App\Ezsell\Traits\ApiCallRestfulTrait;
use App\Ezsell\Traits\LocationTrait;

abstract class Controller extends BaseController implements IController {
	/**
	 * TRAITS
	 */
	use UtilTrait, LocationTrait, RestfulTrait, ApiCallRestfulTrait, MailerTrait, ResponseTrait;
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
	 * @var array
	 */
	protected $_locationMiddlewareOptions = [ ];
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->_middleware_action = $this->getMiddlewareAction ();
		$this->setupMiddlewares ();
	}
	/**
	 *
	 * @return void
	 */
	protected function setupMiddlewares() {
		$this->middleware ( "im.authentication:{$this->_middleware_action}", $this->getAuthenticationMiddlewareOptions () );
		$this->middleware ( "im.authorization:{$this->_middleware_action}", $this->getAuthorizationMiddlewareOptions () );
		$this->middleware ( "im.location:{$this->_middleware_action}", $this->getLocationMiddlewareOptions () );
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
	 * @see \App\Ezsell\Controllers\IController::getAuthenticationMiddlewareOptions()
	 */
	public function getAuthenticationMiddlewareOptions() {
		return $this->_authenticationMiddlewareOptions;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\Ezsell\Controllers\IController::getAuthorizationMiddlewareOptions()
	 */
	public function getAuthorizationMiddlewareOptions() {
		return $this->_authorizationMiddlewareOptions;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\Ezsell\Controllers\IController::getLocationMiddlewareOptions()
	 */
	public function getLocationMiddlewareOptions() {
		return $this->_locationMiddlewareOptions;
	}
}