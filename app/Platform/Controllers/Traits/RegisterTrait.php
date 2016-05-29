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
			return $this->response ( view ( 'base', $this->getPageResponseDataNoBanner ()->setType ( 'RegisterPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.register_failed', $data ) ) ), $response->getStatusCode () );
		} else {
			return $this->response ( view ( 'base', $this->getPageResponseDataNoBanner ()->setType ( 'RegisterPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.registered', $data ) ) ) );
		}
	}
	protected function pajaxpostRegister(Request $request) {
		return $this->jsonResponse ( 'register_page', $this->getPageResponseData ()->setType ( 'RegisterPage' ) );
	}
	protected function pgetRegister(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'base', $this->getPageResponseDataNoBanner ()->setType ( 'RegisterPage' ) ) );
		else
			return $this->redirect ();
	}
}
