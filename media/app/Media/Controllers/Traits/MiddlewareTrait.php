<?php

namespace App\Media\Controllers\Traits;

use Illuminate\Http\Request;
use Exception;
use App\Media\Config\Config;
use Route;
use App\Media\Config\AuthorizationMaps;
use App\Media\Traits\AllTrait;

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
	 * {@inheritDoc}
	 *
	 * @see \App\Ezsell\Controllers\IController::getMiddlewareOptions()
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
