<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\IMController;
use App\User;
use App\Http\Response\Status as ResponseStatus;
use Validator;
use Illuminate\Support\Facades\Auth;

class IMPasswordController extends IMController {
	public function __construct() {
		$this->middleware ( 'jwt.auth', [ 
				'except' => [ 
						'sendActivationCode' 
				] 
		] );
	}
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
	
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function password(Request $request) {
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
		$current_password = $request->get ( 'current_password' );
		if (! $current_password) {
			return $this->json ( 'current_password_not_provided', null, ResponseStatus::PreconditionRequired );
		}
		if (strlen ( $current_password ) > 0 && ! Hash::check ( $current_password, $user->password )) {
			return $this->json ( 'wrong_current_password', null, ResponseStatus::PreconditionFailed );
		}
		if ($msg = $this->passwordValidator ( $request->all () )) {
			return $this->json ( $msg, null, ResponseStatus::PreconditionFailed );
		}
		$user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->json ( null, $user );
	}
}
