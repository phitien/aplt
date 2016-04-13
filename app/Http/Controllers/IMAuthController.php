<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\IMController;
use App\User;
use App\Http\Response\Status as ResponseStatus;
use Validator;

class IMAuthController extends IMController {
	public function __construct() {
		$this->middleware ( 'jwt.auth', [ 
				'except' => [ 
						'login',
						'register',
						'activate',
						'sendActivationCode' 
				] 
		] );
	}
	/**
	 * Return the user
	 *
	 * @return Response
	 */
	public function index(Request $request) {
		$users = User::all ();
		return $users;
	}
	/**
	 * Return a JWT
	 *
	 * @return Response
	 */
	public function register(Request $request) {
		$data = $request->all ();
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->json ( $msg, null, ResponseStatus::PreconditionFailed );
		}
		$user = $this->create ( $data );
		return $this->json ( null, $user->activationCode );
	}
	/**
	 * Return a JWT
	 *
	 * @return Response
	 */
	public function login(Request $request) {
		$credentials = $request->only ( 'email', 'password' );
		return $this->doLogin ( $credentials );
	}
	/**
	 *
	 * @param unknown $credentials        	
	 */
	protected function doLogin($credentials) {
		$credentials ['active'] = 1;
		try {
			// verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt ( $credentials )) {
				return $this->json ( 'invalid_credentials', null, ResponseStatus::Unauthorized );
			}
		} catch ( JWTException $e ) {
			// something went wrong
			return $this->json ( 'could_not_create_token', null, ResponseStatus::InternalServerError );
		}
		// if no errors are encountered we can return a JWT
		return $this->json ( null, $token );
	}
	
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function profile() {
		try {
			if (! $user = JWTAuth::parseToken ()->authenticate ()) {
				return $this->json ( 'user_not_found', null, ResponseStatus::NotFound );
			}
		} catch ( Tymon\JWTAuth\Exceptions\TokenExpiredException $e ) {
			return $this->json ( 'token_expired', null, $e->getStatusCode () );
		} catch ( Tymon\JWTAuth\Exceptions\TokenInvalidException $e ) {
			return $this->json ( 'token_invalid', null, $e->getStatusCode () );
		} catch ( Tymon\JWTAuth\Exceptions\JWTException $e ) {
			return $this->json ( 'token_absent', null, $e->getStatusCode () );
		}
		// the token is valid and we have found the user via the sub claim
		return $this->json ( null, $user );
	}
	/**
	 * Activate user
	 *
	 * @param Request $request        	
	 */
	public function activate($activationCode) {
		$ok = User::activateUser ( $activationCode );
		if ($ok == 2) {
			return $this->json ( 'user_already_activated', null );
		} else if ($ok == 1) {
			return $this->json ( 'user_activated', null );
		} else if ($ok == - 1) {
			return $this->json ( 'activation_code_expired', null, ResponseStatus::NotAcceptable );
		} else if ($ok == - 2) {
			return $this->json ( 'invalid_activation_code', null, ResponseStatus::PreconditionFailed );
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
				return $this->json ( null, $user->getActivationCode () );
			} else {
				return $this->json ( 'user_already_activated', null, ResponseStatus::MethodNotAllowed );
			}
		} else {
			return $this->json ( 'email_not_found', null, ResponseStatus::NotFound );
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
				'password' => bcrypt ( $data ['password'] ) 
		] );
	}
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function updateProfile(Request $request) {
		try {
			if (! $user = JWTAuth::parseToken ()->authenticate ()) {
				return $this->json ( 'user_not_found', null, ResponseStatus::NotFound );
			}
		} catch ( Tymon\JWTAuth\Exceptions\TokenExpiredException $e ) {
			return $this->json ( 'token_expired', null, $e->getStatusCode () );
		} catch ( Tymon\JWTAuth\Exceptions\TokenInvalidException $e ) {
			return $this->json ( 'token_invalid', null, $e->getStatusCode () );
		} catch ( Tymon\JWTAuth\Exceptions\JWTException $e ) {
			return $this->json ( 'token_absent', null, $e->getStatusCode () );
		}
		$user->fill ( $request->all () );
		$user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->json ( null, $user );
	}
}
