<?php

namespace App\IM\Controllers;

use App\IM\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Hash;
use App\IM\Controllers\Traits\LoginTrait;
use App\IM\Traits\UserTrait;

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
		if (strlen ( $current_password ) > 0 && ! Hash::check ( $current_password, $this->user ()->password )) {
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
	/**
	 * Validate user name
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateProfileData(array $data) {
		$email = $data ['second_email'];
		if ($email != $this->user ()->second_email) {
			$validator = Validator::make ( $data, [ 
					'second_email' => 'unique:users,second_email' 
			] );
			if ($validator->fails ()) {
				return 'second_email_used';
			}
		}
		$mobile = $data ['mobile'];
		if ($mobile != $this->user ()->mobile) {
			$validator = Validator::make ( $data, [ 
					'mobile' => 'unique:users,mobile' 
			] );
			if ($validator->fails ()) {
				return 'mobile_used';
			}
		}
	}
}
