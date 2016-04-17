<?php

namespace App\IM\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\IM\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\IM\Utils;
use App\IM\Models\User\Traits\MailerTrait;
use Validator;
use Hash;

abstract class AuthenticableController extends Controller {
	/**
	 * TRAITS
	 */
	use MailerTrait;
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function login(Request $request) {
		$credentials = $request->only ( 'email', 'password' );
		return $this->doLogin ( $credentials );
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin($credentials) {
		$credentials ['active'] = 1;
		try {
			// verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt ( $credentials )) {
				return $this->jsonResponse ( 'invalid_credentials', null, Response::HTTP_UNAUTHORIZED );
			}
		} catch ( Exception $e ) {
			// something went wrong
			return $this->jsonResponse ( 'could_not_create_token', null, Response::HTTP_BAD_REQUEST );
		}
		return Utils::setResponseCookieToken ( $this->jsonResponse ( 'login_successfully', $token ), $token );
	}
	/**
	 * Logout
	 *
	 * @return Response
	 */
	public function logout() {
		return $this->doLogout ();
	}
	/**
	 *
	 * @return void
	 */
	protected function doLogout() {
		JWTAuth::invalidate ( JWTAuth::getToken () );
		return Utils::unsetResponseCookieToken ( $this->jsonResponse ( 'logged_out', null ) );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response void
	 */
	protected function enterWrongPassword(Request $request) {
		$current_password = $request->get ( 'current_password' );
		if (! $current_password) {
			return $this->jsonResponse ( 'current_password_not_provided', null, Response::HTTP_BAD_REQUEST );
		}
		if (strlen ( $current_password ) > 0 && ! Hash::check ( $current_password, $this->_user->password )) {
			return $this->jsonResponse ( 'current_password_incorrect', null, Response::HTTP_BAD_REQUEST );
		}
		return false;
	}
	/**
	 * Validate user email
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateEmail(array $data) {
		$validator = Validator::make ( $data, [ 
				'email' => 'required|email|max:255' 
		] );
		if ($validator->fails ()) {
			return 'invalid_email';
		}
		$validator = Validator::make ( $data, [ 
				'email' => 'unique:users,email' 
		] );
		if ($validator->fails ()) {
			return 'email_used';
		}
		$validator = Validator::make ( $data, [ 
				'email' => 'confirmed' 
		] );
		if ($validator->fails ()) {
			return 'email_confirmation_not_matched';
		}
	}
	/**
	 * Validate user password
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validatePassword(array $data) {
		$validator = Validator::make ( $data, [ 
				'password' => 'required|min:6' 
		] );
		if ($validator->fails ()) {
			return 'invalid_password';
		}
		$validator = Validator::make ( $data, [ 
				'password' => 'confirmed' 
		] );
		if ($validator->fails ()) {
			return 'password_confirmation_not_matched';
		}
	}
	/**
	 * Validate user name
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateName(array $data) {
		$validator = Validator::make ( $data, [ 
				'name' => 'required|min:3|max:30|regex:/^[a-z0-9]([\._]?[a-z0-9]+)+$/' 
		] );
		if ($validator->fails ()) {
			return 'invalid_name';
		}
		$validator = Validator::make ( $data, [ 
				'name' => 'unique:users,name' 
		] );
		if ($validator->fails ()) {
			return 'name_used';
		}
	}
}
