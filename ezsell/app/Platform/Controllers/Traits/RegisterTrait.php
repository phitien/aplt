<?php

namespace App\Platform\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait  RegisterTrait {
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function register(Request $request) {
		return $this->process ( 'register', func_get_args () );
	}
	protected function ppostRegister(Request $request) {
		$data = $request->only ( 'email', 'email_confirmation', 'password', 'password_confirmation' );
		$response = static::apiCallRegister ( $data );
		if ($response->getStatusCode () != Response::HTTP_OK) {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'register', [ 
					'appMessage' => trans ( 'messages.sentences.register_failed', [ 
							'reason' => trans ( "messages.errors.{$data ['message']}" ) 
					] ) 
			] ), $response->getStatusCode () );
		} else {
			return $this->response ( view ( 'register', [ 
					'appMessage' => trans ( 'messages.sentences.registered' ) 
			] ) );
		}
	}
	protected function pgetRegister(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'register' ) );
		else
			return $this->redirect ();
	}
}
