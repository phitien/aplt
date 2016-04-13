<?php

namespace App\IM\Controllers;

use App\IM\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\IM\Middleware\Registration;
use App\IM\Response\Status;
use Illuminate\Http\Request;

class RegisterController extends Controller {
	public function __construct() {
		$this->middleware ( [ 
				Registration::class 
		], [ 
				'except' => [ ] 
		] );
	}
	/**
	 * Return a JWT
	 *
	 * @return Response
	 */
	public function register(Request $request) {
		$data = $request->all ();
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->jsonResponse ( $msg, null, Status::PreconditionFailed );
		}
		$user = $this->create ( $data );
		return $this->jsonResponse ( null, $user->activationCode );
	}
	/**
	 * Activate user
	 *
	 * @param Request $request        	
	 */
	public function activate($activationCode) {
		$ok = User::activateUser ( $activationCode );
		if ($ok == 2) {
			return $this->jsonResponse ( 'user_already_activated', null );
		} else if ($ok == 1) {
			return $this->jsonResponse ( 'user_activated', null );
		} else if ($ok == - 1) {
			return $this->jsonResponse ( 'activation_code_expired', null, Status::NotAcceptable );
		} else if ($ok == - 2) {
			return $this->jsonResponse ( 'invalid_activation_code', null, Status::PreconditionFailed );
		}
	}
	/**
	 * Send activation code
	 *
	 * @param Request $request        	
	 */
	public function sendActivationCode(Request $request) {
		$email = $request->get ( 'email' );
		$user = User::where ( 'email', '=', $email )->first ();
		if ($user) {
			if (! $user->isActivated ()) {
				return $this->jsonResponse ( null, $user->getActivationCode () );
			} else {
				return $this->jsonResponse ( 'user_already_activated', null, Status::MethodNotAllowed );
			}
		} else {
			return $this->jsonResponse ( 'email_not_found', null, Status::NotFound );
		}
	}
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function registrationValidator(array $data) {
		$validator = Validator::make ( $data, [ 
				'email' => 'required|email|max:255' 
		] );
		if ($validator->fails ()) {
			return 'invalid_email';
		}
		$validator = Validator::make ( $data, [ 
				'email' => 'unique:users' 
		] );
		if ($validator->fails ()) {
			return 'email_used';
		}
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
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data        	
	 * @return User
	 */
	protected function create(array $data) {
		return User::create ( [ 
				'name' => isset ( $data ['name'] ) ? $data ['name'] : uniqid ( 'IM' ),
				'email' => $data ['email'],
				'password' => $this->encode ( $data ['password'] ) 
		] );
	}
}
