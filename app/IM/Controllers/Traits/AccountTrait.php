<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait AccountTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		if ($msg = $this->validatePassword ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$new_password = $request->request->get ( 'password' );
		if (Hash::check ( $new_password, $this->user ()->password )) {
			return $this->jsonResponse ( 'password_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		$credentials = [ 
				'email' => $this->user ()->email,
				'password' => $this->user ()->changePassword ( $new_password ) 
		];
		return $this->updateJsonResponse ( $this->doLogin ( $credentials ), 'password_changed', null );
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
		if ($email == $this->user ()->email) {
			return $this->jsonResponse ( 'email_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		if ($msg = $this->validateEmail ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$this->sendEmailChangedEmail ( $this->user (), $email );
		$this->sendActivationEmail ( $this->user () );
		return $this->updateJsonResponse ( $this->doLogout (), 'user_email_changed', 'Please active your account at ' . $this->user ()->email );
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
		if ($name == $this->user ()->name) {
			return $this->jsonResponse ( 'name_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		if ($msg = $this->validateName ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$this->user ()->changeName ( $name );
		return $this->jsonResponse ( 'name_changed', null );
	}
}
