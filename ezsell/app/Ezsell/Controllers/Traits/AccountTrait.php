<?php

namespace App\Ezsell\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;

trait AccountTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiPassword ( $request );
		} else {
			return $this->showPassword ( $request );
		}
		
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		if ($msg = $this->validatePassword ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$new_password = $request->request->get ( 'password' );
		if (Hash::check ( $new_password, static::getUser ()->password )) {
			return $this->jsonResponse ( 'password_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		$credentials = [ 
				'email' => static::getUser ()->email,
				'password' => static::getUser ()->changePassword ( $new_password ) 
		];
		return $this->updateJsonResponse ( $this->doLogin ( $credentials ), 'password_changed', null );
	}
	protected function apiPassword(Request $request) {
		$data = $request->only ( 'current_password', 'password', 'password_confirmation' );
		$response = static::apiCallPassword ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'ok.register', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ) );
		} else {
			print_r(json_decode ( $response->getBody (), true ));
			return $this->response ( View::make ( 'ko.register', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	protected function showPassword(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->response ( View::make ( 'password' ) );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function reset(Request $request) {
		// TODO
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function email(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		$email = $request->request->get ( 'email' );
		if ($email == static::getUser ()->email) {
			return $this->jsonResponse ( 'email_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		if ($msg = $this->validateEmail ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$this->sendEmailChangedEmail ( static::getUser (), $email );
		$this->sendActivationEmail ( static::getUser () );
		return $this->updateJsonResponse ( $this->doLogout (), 'user_email_changed', 'Please active your account at ' . static::getUser ()->email );
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function account(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		$name = $request->request->get ( 'name' );
		if ($name == static::getUser ()->name) {
			return $this->jsonResponse ( 'name_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		if ($msg = $this->validateName ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		static::getUser ()->changeName ( $name );
		return $this->jsonResponse ( 'name_changed', null );
	}
}
