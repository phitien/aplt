<?php

namespace App\Shared\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use App\Shared\Config;
use Route;
use App\Shared\Config\AuthorizationMaps;

abstract class Controller extends BaseController implements IController {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->setupMiddlewares ();
	}
	/**
	 *
	 * @param array $arguments        	
	 * @param string $action        	
	 * @return Response
	 */
	protected function process($action, array $arguments) {
		$action = ucfirst ( $action );
		$ajax = request ()->ajax () ? 'ajax' : '';
		$method = "p{$ajax}get{$action}";
		if (request ()->isMethod ( 'post' )) {
			$method = "p{$ajax}post{$action}";
		} else if (request ()->isMethod ( 'put' )) {
			$method = "p{$ajax}put{$action}";
		} else if (request ()->isMethod ( 'delete' )) {
			$method = "p{$ajax}delete{$action}";
		}
		return call_user_func_array ( array (
				$this,
				$method 
		), $arguments );
	}
	/**
	 *
	 * @var string
	 */
	protected $_middleware_action = Config::ACTION_GUEST_ACT;
	/**
	 *
	 * @var string
	 */
	protected $_middlewares = [ 
			'im.authentication',
			'im.authorization' 
	];
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
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\Shared\Controllers\IController::getMiddlewareOptions()
	 */
	public function getMiddlewareOptions($middleware) {
		switch ($middleware) {
			case 'im.authentication' :
				return $this->_authenticationMiddlewareOptions;
			case 'im.authorization' :
				return $this->_authorizationMiddlewareOptions;
			default :
				return [ ];
		}
	}
	/**
	 *
	 * @return void
	 */
	protected function setupMiddlewares() {
		$this->_middleware_action = $this->getMiddlewareAction ();
		foreach ( $this->_middlewares as $middleware ) {
			$this->middleware ( "{$middleware}:{$this->_middleware_action}", $this->getMiddlewareOptions ( $middleware ) );
		}
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
}