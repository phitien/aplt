<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;

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
		if (Hash::check ( $new_password, static::getUser ()->password )) {
			return $this->jsonResponse ( 'password_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		$credentials = [ 
				'email' => static::getUser ()->email,
				'password' => static::getUser ()->changePassword ( $new_password ) 
		];
		return $this->updateJsonResponse ( $this->setResponseToken ( $this->doLogin ( $credentials ) ), 'password_changed', null );
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
		$oldEmail = static::getUser ()->email;
		if ($msg = $this->validateEmail ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		if ($email == $oldEmail) {
			return $this->jsonResponse ( 'email_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		static::getUser ()->changeEmail ( $email );
		static::getUser ()->email = $oldEmail;
		$this->sendEmailChangedEmail ( static::getUser (), $email );
		static::getUser ()->email = $email;
		$this->sendActivationEmail ( static::getUser () );
		return $this->updateJsonResponse ( $this->setResponseToken ( $this->doLogout () ), 'user_email_changed', 'Please active your account at ' . static::getUser ()->email );
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
