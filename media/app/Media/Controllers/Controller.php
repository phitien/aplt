<?php

namespace App\Media\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Exception;
use App\Media\Config\Config;
use Route;
use Illuminate\Http\Request;
use App\Media\Config\AuthorizationMaps;
use App\Media\Traits\MailerTrait;
use App\Media\Traits\ResponseTrait;
use App\Media\Traits\UtilTrait;
use App\Media\Traits\RestfulTrait;
use App\Media\Traits\ApiCallRestfulTrait;
use Illuminate\Http\Response;

abstract class Controller extends BaseController implements IController {
	/**
	 * TRAITS
	 */
	use UtilTrait, RestfulTrait, ApiCallRestfulTrait, MailerTrait, ResponseTrait;
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
	}
	/**
	 *
	 * @return string|string|string[]|string
	 */
	protected function getMiddlewareAction() {
		$arr = explode ( '@', Route::getCurrentRoute ()->getActionName () );
		$controller = $arr [0];
		$method = $arr [1];
		$requestType = request ()->method ();
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
	 * @see \App\Media\Controllers\IController::getAuthenticationMiddlewareOptions()
	 */
	public function getAuthenticationMiddlewareOptions() {
		return $this->_authenticationMiddlewareOptions;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\Media\Controllers\IController::getAuthorizationMiddlewareOptions()
	 */
	public function getAuthorizationMiddlewareOptions() {
		return $this->_authorizationMiddlewareOptions;
	}
	/**
	 *
	 * @param array $arguments
	 * @param string $action        	
	 * @return Response
	 */
	protected function process($action, array $arguments) {
		$action = ucfirst ( $action );
		$method = "get{$action}";
		if (request ()->isMethod ( 'post' )) {
			$method = "post{$action}";
		} else if (request ()->isMethod ( 'put' )) {
			$method = "put{$action}";
		} else if (request ()->isMethod ( 'delete' )) {
			$method = "delete{$action}";
		}
		return call_user_func_array ( array (
				$this,
				$method 
		), $arguments );
	}
}