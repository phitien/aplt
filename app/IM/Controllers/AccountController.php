<?php

namespace App\IM\Controllers;

use App\IM\Controllers\Controller;
use App\User;
use Validator;
use App\IM\Middleware\Authentication;
use Illuminate\Http\Request;
use Hash;
use App\IM\Response\Status;

class AccountController extends Controller {
	protected $_im_middlewares = [ 
			Authentication::class 
	];
	protected $_im_middlewaresOptions = [ ];
	protected $_im_middlewaresExceptOption = [ 
			'reset' 
	];
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function passwordValidator(array $data) {
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
	protected function enterWrongPassword(Request $request) {
		$current_password = $request->get ( 'current_password' );
		if (! $current_password) {
			return $this->jsonResponse ( 'current_password_not_provided', null, Status::PreconditionRequired );
		}
		if (strlen ( $current_password ) > 0 && ! Hash::check ( $current_password, $this->_user->password )) {
			return $this->jsonResponse ( 'current_password_incorrect', null, Status::PreconditionFailed );
		}
		return false;
	}
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function password(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		if ($msg = $this->passwordValidator ( $request->all () )) {
			return $this->jsonResponse ( $msg, null, Status::PreconditionFailed );
		}
		$new_password = $request->get ( 'password' );
		if (Hash::check ( $new_password, $this->_user->password )) {
			return $this->jsonResponse ( 'same_new_password', null, Status::PreconditionFailed );
		}
		$this->_user->password = $this->encode ( $new_password );
		$this->_user->save ();
		$credentials = [ 
				'email' => $this->_user->email,
				'password' => $new_password 
		];
		return $this->doLogin ( $credentials );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 */
	public function reset(Request $request) {
		// TODO
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 */
	public function email(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		// TODO
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 */
	public function account(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		// TODO
	}
}
