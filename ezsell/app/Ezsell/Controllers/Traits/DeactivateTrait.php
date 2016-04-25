<?php

namespace App\Ezsell\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;

trait DeactivateTrait {
	/**
	 * Deactivate user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function deactivate(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiDeactivate ( $request );
		} else {
			return $this->showDeactivate ( $request );
		}
	}
	protected function apiDeactivate(Request $request) {
		$response = static::apiCallDeactive ( $request->get ( 'password' ) );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'index' ) );
		} else {
			return $this->response ( View::make ( 'ko.deactivate', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	protected function showDeactivate(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->response ( View::make ( 'deactivate' ) );
	}
}