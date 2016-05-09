<?php

namespace App\Ezsell\Controllers\Traits;

use App\Ezsell\Config\Config;
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
		$response = static::apiCallDeactive ( $request->get ( 'current_password' ) );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( View::make ( 'deactivate', [ 
					'appMessage' => "Hehe, deactivate được rồi !!" 
			] ) );
		} else {
			$data = json_decode ( $response->getBody (), true );
			return $this->response ( View::make ( 'deactivate', [ 
					'appMessage' => "Hỏng rồi, không deactivate được, lý do vì {$data['message']}. Thử lại phát đi." 
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