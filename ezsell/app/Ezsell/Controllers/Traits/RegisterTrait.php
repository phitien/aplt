<?php

namespace App\Ezsell\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;

trait  RegisterTrait {
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function register(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiRegister ( $request );
		} else {
			return $this->showRegister ( $request );
		}
	}
	protected function apiRegister(Request $request) {
		$data = $request->only ( 'email', 'email_confirmation', 'password', 'password_confirmation' );
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->response ( View::make ( 'register', [ 
					'ezsellMessage' => "Hỏng rồi, không đăng ký được, lý do vì {$msg}. Thử lại phát đi." 
			] ), Response::HTTP_BAD_REQUEST );
		}
		$response = static::apiCallRegister ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'register', [ 
					'ezsellMessage' => "Hehe đăng ký ok rồi đấy, đăng nhập email và activate account ngay đi :)." 
			] ) );
		} else {
			$data = json_decode ( $response->getBody (), true );
			return $this->response ( View::make ( 'register', [ 
					'ezsellMessage' => "Hỏng rồi, không đăng ký được, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	protected function showRegister(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'register' ) );
		else
			return $this->redirect ();
	}
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function registrationValidator(array $data) {
		if ($message = $this->validateEmail ( $data )) {
			return $message;
		}
		return $this->validatePassword ( $data );
	}
}
