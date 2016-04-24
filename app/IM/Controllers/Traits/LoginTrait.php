<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use Exception;
use App\User;

trait  LoginTrait {
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function login(Request $request) {
		$credentials = $request->only ( 'email', 'password' );
		return $this->doLogin ( $credentials );
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin($credentials) {
		try {
			if (! ($credentials instanceof User)) {
				$user = User::where ( 'email', $credentials ['email'] )->first ();
				$credentials ['active'] = 1;
				if (! $user)
					return $this->jsonResponse ( 'invalid_credentials', null, Response::HTTP_UNAUTHORIZED );
					// verify the credentials and create a token for the user
				if (! $token = JWTAuth::attempt ( $credentials ))
					return $this->jsonResponse ( 'user_is_not_active', null, Response::HTTP_UNAUTHORIZED );
			} else {
				if (! $credentials->active)
					return $this->jsonResponse ( 'user_is_not_active', null, Response::HTTP_UNAUTHORIZED );
				if (! $token = JWTAuth::fromUser ( $credentials ))
					return $this->jsonResponse ( 'could_not_create_token', null, Response::HTTP_UNAUTHORIZED );
			}
		} catch ( Exception $e ) {
			// something went wrong
			return $this->jsonResponse ( 'could_not_create_token', null, Response::HTTP_UNAUTHORIZED );
		}
		$this->setToken ( $token );
		$this->setUser ( JWTAuth::authenticate ( $token ) );
		return $this->setResponseToken ( $this->jsonResponse ( 'login_successfully', $this->user () ) );
	}
	/**
	 * Logout
	 *
	 * @return Response
	 */
	public function logout() {
		return $this->doLogout ();
	}
	/**
	 *
	 * @return void
	 */
	protected function doLogout() {
		JWTAuth::invalidate ( $this->token () );
		$this->setToken ( null );
		return $this->jsonResponse ( 'logged_out', null );
	}
}
