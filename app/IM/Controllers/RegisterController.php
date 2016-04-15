<?php

namespace App\IM\Controllers;

use App\IM\Controllers\AuthenticableController;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\IM\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends AuthenticableController {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'register',
					'activate',
					'deactivate',
					'sendActivationCode' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ ];
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function register(Request $request) {
		$data = $request->request->all ();//only get post data
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->jsonResponse ( $msg, null, Status::PreconditionFailed );
		}
		$user = User::createUser ( [ 
				'name' => isset ( $data ['name'] ) ? $data ['name'] : uniqid ( 'IM' ),
				'email' => $data ['email'],
				'password' => $this->encode ( $data ['password'] ) 
		] );
		return $this->jsonResponse ( 'user_registered', $user->activationCode );
	}
	
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return string
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
	 * Activate user
	 *
	 * @param Request $request        	
	 * @param string $activationCode        	
	 * @return Response
	 */
	public function activate(Request $request, $activationCode) {
		$ok = User::activateUser ( $activationCode );
		if ($ok == 2) {
			return $this->jsonResponse ( 'user_already_activated', null );
		} else if ($ok == 1) {
			return $this->jsonResponse ( 'user_activated', null );
		} else if ($ok == - 1) {
			return $this->jsonResponse ( 'activation_code_expired', null, Status::BadRequest );
		} else if ($ok == - 2) {
			return $this->jsonResponse ( 'invalid_activation_code', null, Status::BadRequest );
		}
	}
	/**
	 * Send activation code
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function sendActivationCode(Request $request) {
		$email = $request->get ( 'email' );
		$user = User::where ( 'email', '=', $email )->first ();
		if ($user) {
			if (! $user->isActivated ()) {
				return $this->jsonResponse ( 'activation_code_sent', $user->getActivationCode () );
			} else {
				return $this->jsonResponse ( 'user_already_activated', null, Status::BadRequest );
			}
		} else {
			return $this->jsonResponse ( 'email_not_found', null, Status::BadRequest );
		}
	}
	/**
	 * Deactivate user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function deactivate(Request $request) {
		$ok = $this->getUser ()->deactivate ();
		$this->doLogout();
		if ($ok) {
			return $this->jsonResponse ( 'deactivated_successfully', null );
		} else {
			return $this->jsonResponse ( 'deactivated_unsuccessfully', null, Status::BadRequest );
		}
	}
}
