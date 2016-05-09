<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Models\Location;

class LocationController extends BaseController {
	/**
	 *
	 * @var array $_locationMiddlewareOptions
	 */
	protected $_locationMiddlewareOptions = [ 
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
		if ($request->isMethod ( 'post' )) {
			return $this->saveLocation ( $request );
		} else {
			return $this->searchLocation ( $request );
		}
	}
	protected function saveLocation(Request $request) {
		$location = $request->get ( 'location' );
		static::setLocation ( $location );
		return $this->redirect ( static::getRedirectUri () );
	}
	protected function searchLocation(Request $request) {
		$locations = Location::search ( $request->get ( 'q' ) );
		return $this->jsonResponse ( 'locations', $locations );
	}
}
