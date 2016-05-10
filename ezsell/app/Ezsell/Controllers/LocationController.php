<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use View;
use App\Ezsell\Config\LocationMap;

class LocationController extends BaseController {
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
		if ($request->isMethod ( 'post' )) {
			return $this->saveLocation ( $request );
		} else {
			return $this->showLocation ( $request );
		}
	}
	protected function showLocation(Request $request) {
		return $this->response ( View::make ( 'location' ) );
	}
	protected function saveLocation(Request $request) {
		$location_id = $request->get ( 'location' );
		static::setLocationId ( $location_id );
		return $this->redirect ( static::getRedirectUri () );
	}
	public function searchlocation(Request $request) {
		$locations = LocationMap::search ( $request->get ( 'q' ) );
		return $this->jsonResponse ( 'locations', $locations );
	}
}
