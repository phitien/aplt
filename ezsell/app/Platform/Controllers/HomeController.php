<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use App\Platform\Response\ResponseData;

class HomeController extends Controller {
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
			'except' => [ ] 
	];
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return $this->process ( 'index', func_get_args () );
	}
	protected function pgetIndex(Request $request) {
		return $this->response ( view ( 'base', $this->getResponseData ( $request ) ) );
	}
	protected function pajaxIndex(Request $request) {
		return $this->jsonResponse ( $this->getResponseData ( $request ) );
	}
	protected function getResponseData(Request $request) {
		return [ 
				'configurations' => (new ResponseData ( 'HomePage' ))->setShowBanner ( true )->setShowLeft ( 2 )->setShowRight ( 2 )->getData () 
		];
	}
}
