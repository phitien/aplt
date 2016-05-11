<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use View;

class ItemController extends BaseController {
	/**
	 * Traits
	 */
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ ] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ ] 
	];
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return $this->response ( View::make ( 'index' ) );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function newitem(Request $request) {
		return $this->process ( 'newitem', $request );
	}
	protected function getNewitem(Request $request) {
		return $this->response ( View::make ( 'newitem' ) );
	}
}
