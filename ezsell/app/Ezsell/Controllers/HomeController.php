<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use View;

class HomeController extends AuthenticableController {
	/**
	 * Traits
	 */
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'index' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ 
					'index' 
			] 
	];
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return $this->response ( View::make ( 'index' ) );
	}
}
