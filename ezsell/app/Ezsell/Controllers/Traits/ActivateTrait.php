<?php

namespace App\Ezsell\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use View;

trait  ActivateTrait {
	/**
	 * Activate user
	 *
	 * @param Request $request        	
	 * @param string $code        	
	 * @return Response
	 */
	public function activate(Request $request, $code) {
		$response = static::apiCallActivate ( $code );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'ok.activate', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ) );
		} else {
			return $this->response ( View::make ( 'ko.activate', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	/**
	 * Send activation code
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function code(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiCode ( $request );
		} else {
			return $this->showCode ( $request );
		}
	}
	protected function apiCode(Request $request) {
		$email = $request->get ( 'email' );
		if ($msg = $this->emailValidator ( [ 
				'email' => $email 
		] )) {
			return $this->response ( View::make ( 'ko.code', [ 
					'email' => $email,
					'data' => [ 
							'message' => $msg 
					] 
			] ), Response::HTTP_BAD_REQUEST );
		}
		$response = static::apiCallCode ( [ 
				'email' => $email 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'ok.code', [ 
					'email' => $email,
					'data' => json_decode ( $response->getBody (), true ) 
			] ) );
		} else {
			return $this->response ( View::make ( 'ko.code', [ 
					'email' => $email,
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	protected function showCode(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'code' ) );
		else
			return $this->redirect ();
	}
	protected function emailValidator(array $data) {
		$validator = Validator::make ( $data, [ 
				'email' => 'required|email|max:255' 
		] );
		if ($validator->fails ()) {
			return 'invalid_email';
		}
	}
}
