<?php

namespace App\IM\Controllers\Traits;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait  RegisterTrait {
	/**
	 * Return a JWT
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request) {
		$data = $request->request->all (); // only get post data
		if ($msg = $this->registrationValidator ( $data )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$user = User::createUser ( $data );
		$this->sendActivationEmail ( $user );
		return $this->jsonResponse ( 'user_registered', 'Please active your account at ' . $user->email );
	}
	
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function registrationValidator(array $data) {
		if ($message = $this->validateEmail ( $data )) {
			return $message;
		}
		return $this->validatePassword ( $data );
	}
}
