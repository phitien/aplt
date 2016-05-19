<?php

namespace App\Ezsell\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Response;
use App\Ezsell\Controllers\Traits\MiddlewareTrait;

abstract class Controller extends BaseController implements IController {
	/**
	 * TRAITS
	 */
	use MiddlewareTrait;
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
		$method = "pget{$action}";
		
		if (request ()->ajax ()) {
			$method = "pajax{$action}";
		} else if (request ()->isMethod ( 'post' )) {
			$method = "ppost{$action}";
		} else if (request ()->isMethod ( 'put' )) {
			$method = "pput{$action}";
		} else if (request ()->isMethod ( 'delete' )) {
			$method = "pdelete{$action}";
		}
		return call_user_func_array ( array (
				$this,
				$method 
		), $arguments );
	}
}