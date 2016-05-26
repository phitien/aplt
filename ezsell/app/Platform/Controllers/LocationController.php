<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use App\Platform\Config\LocationMap;

class LocationController extends Controller {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'location',
					'searchlocation' 
			] 
	];
	/**
	 *
	 * @var array $_locationMiddlewareOptions
	 */
	protected $_locationMiddlewareOptions = [ 
			'except' => [ 
					'location',
					'searchlocation' 
			] 
	];
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function location(Request $request) {
		return $this->process ( 'location', func_get_args () );
	}
	protected function pgetLocation(Request $request) {
		return $this->response ( view ( 'base', 

		$this->getPageResponseData ()->setType ( 'ChangeLocationPage' )->setShowBanner ( true )->setShowLeft ( 2 )->setShowRight ( 2 ) ) );
	}
	protected function ppostLocation(Request $request) {
		$location_id = $request->get ( 'location' );
		static::setLocationId ( $location_id );
		return $this->redirect ( static::getRedirectUri () );
	}
	protected function pajaxpostLocation(Request $request) {
		$location_id = $request->get ( 'location' );
		static::setLocationId ( $location_id );
		return $this->redirect ( static::getRedirectUri () );
	}
	public function searchlocation(Request $request) {
		$locations = LocationMap::search ( $request->get ( 'q' ) );
		return $this->jsonResponse ( 'locations', $locations );
	}
}
