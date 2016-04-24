<?php

namespace App\Ezsell\Controllers\Traits;

use Illuminate\Http\Request;

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
		$response = $this->restful_post ( 'api/deactivate', [ 
				'email' => $email 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ()->view ( 'ok.code', [ 
					'email' => $email,
					'data' => json_decode ( $response->getBody (), true ) 
			] );
		} else {
			return $this->response ()->view ( 'ko.code', [ 
					'email' => $email,
					'data' => json_decode ( $response->getBody (), true ) 
			] );
		}
	}
	protected function showDeactivate(Request $request) {
		return view ( 'deactivate' );
	}
}