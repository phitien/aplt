<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;

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
		return $this->response ( view ( 'base', $this->preparePageResponseData ( $request ) ) );
	}
	protected function pajaxpostIndex(Request $request) {
		return $this->jsonResponse ( 'home_page', $this->preparePageResponseData ( $request ) );
	}
	protected function preparePageResponseData(Request $request) {
		return $this->getPageResponseData ()->setType ( 'HomePage' )->setShowBanner ( true )->setShowLeft ( 2 )->setShowRight ( 2 );
	}
}
