<?php

namespace App\Platform\Controllers\Traits;

use Illuminate\Http\Request;
use Exception;
use App\Platform\Config;
use Route;
use App\Platform\Config\AuthorizationMaps;
use App\Platform\Traits\AllTrait;

trait MiddlewareTrait {
	use AllTrait;
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
			'im.authorization',
			'im.location' 
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
	 * @see \App\Platform\Controllers\IController::getMiddlewareOptions()
	 */
	public function getMiddlewareOptions($middleware) {
		switch ($middleware) {
			case 'im.authentication' :
				return $this->_authenticationMiddlewareOptions;
			case 'im.authorization' :
				return $this->_authorizationMiddlewareOptions;
			case 'im.location' :
				return $this->_locationMiddlewareOptions;
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
