<?php

namespace App\IM\Controllers\Traits;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\IM\Utils;

trait  RegisterTrait {
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function register(Request $request) {
		$data = $request->request->all (); // only get post data
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
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
		return $this->passwordValidate ( $data );
	}
}
