<?php

namespace App\Ezsell\Controllers;

use App\Ezsell\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Hash;
use App\Ezsell\Controllers\Traits\LoginTrait;
use App\Ezsell\Traits\UserTrait;

abstract class AuthenticableController extends Controller {
	/**
	 * Traits
	 */
	use LoginTrait, UserTrait;
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
		if (strlen ( $current_password ) > 0 && ! Hash::check ( $current_password, static::getUser ()->password )) {
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
	}
	/**
	 * Validate user name
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateProfileData(array $data) {
	}
}
