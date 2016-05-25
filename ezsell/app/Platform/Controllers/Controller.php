<?php

namespace App\Platform\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Response;
use App\Platform\Controllers\Traits\MiddlewareTrait;

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
}