<?php

namespace App\Ezsell\Controllers\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait DeactivateTrait {
	/**
	 * Deactivate user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function deactivate(Request $request) {
		return $this->process ( 'deactivate', func_get_args () );
	}
	protected function postDeactivate(Request $request) {
		$response = static::apiCallDeactive ( $request->get ( 'current_password' ) );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( view ( 'deactivate', [ 
					'appMessage' => "Hehe, deactivate được rồi !!" 
			] ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'deactivate', [ 
					'appMessage' => "Hỏng rồi, không deactivate được, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	protected function getDeactivate(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'login' ) );
		else
			return $this->response ( view ( 'deactivate' ) );
	}
}