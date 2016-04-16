<?php

namespace App\IM\Controllers;

use App\IM\Controllers\AuthenticableController;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\IM\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\IM\Models\User\Traits\MailerTrait;
use App\IM\Utils;

class RegisterController extends AuthenticableController {
	/**
	 * TRAITS
	 */
	use MailerTrait;
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
		$data = $request->request->all (); // only get post data
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->jsonResponse ( $msg, null, Status::PreconditionFailed );
		}
		$user = User::createUser ( [ 
				'name' => isset ( $data ['name'] ) ? $data ['name'] : uniqid ( 'IM' ),
				'email' => $data ['email'],
				'password' => $this->encode ( $data ['password'] ),
				'baseUrl' => Utils::getRequestBaseUrl () 
		] );
		$url = Utils::getRequestBaseUrl () . '/api/activate/' . $user->activationCode;
		static::mailTo ( $user, 'register', 'Welcome to EZSell', [ 
				'title' => 'Welcome to EZSell',
				'receiver' => $user,
				'url' => $url 
		] );
		return $this->jsonResponse ( 'user_registered', 'Please active your account at ' . $user->email );
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
		$data = User::decodeActivationCode ( $activationCode );
		if (! $data)
			return $this->jsonResponse ( 'invalid_activation_code', null, Status::BadRequest );
		if (! ($user = User::find ( $data [1] )))
			return $this->jsonResponse ( 'invalid_activation_code', null, Status::BadRequest );
		if ($user->email != $data [2])
			return $this->jsonResponse ( 'invalid_activation_code', null, Status::BadRequest );
		if (! $user->activate ( $activationCode ))
			return $this->jsonResponse ( 'invalid_activation_code_expired', null, Status::BadRequest );
		$url = $user->baseUrl ? $user->baseUrl : '/';
		header ( "Location: $url" );
		exit ();
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
				$user->createActivationCode ();
				$url = Utils::getRequestBaseUrl () . '/api/activate/' . $user->activationCode;
				static::mailTo ( $user, 'register', 'Activation Re-send', [ 
						'title' => 'Activation Re-send',
						'receiver' => $user,
						'url' => $url 
				] );
				return $this->jsonResponse ( 'activation_code_sent', 'Please active your account at ' . $user->email );
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
		$ok = $this->_user->deactivate ();
		$this->doLogout ();
		if ($ok) {
			return $this->jsonResponse ( 'deactivated_successfully', null );
		} else {
			return $this->jsonResponse ( 'deactivated_unsuccessfully', null, Status::BadRequest );
		}
	}
}
