<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Config\LocationMap;

class LocationController extends BaseController {
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
	protected function getLocation(Request $request) {
		return $this->response ( view ( 'location' ) );
	}
	protected function postLocation(Request $request) {
		$location_id = $request->get ( 'location' );
		static::setLocationId ( $location_id );
		return $this->redirect ( static::getRedirectUri () );
	}
	public function searchlocation(Request $request) {
		$locations = LocationMap::search ( $request->get ( 'q' ) );
		return $this->jsonResponse ( 'locations', $locations );
	}
}
