<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use App\IM\Models\User;
use App\IM\Config;

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
		if (! ($credentials instanceof User)) {
			$user = User::where ( 'email', $credentials ['email'] )->first ();
			if (! $user)
				return $this->jsonResponse ( 'user_not_found', null, Response::HTTP_UNAUTHORIZED );
			if ($user && ! $user->active)
				return $this->jsonResponse ( 'user_is_not_activated', null, Response::HTTP_UNAUTHORIZED );
			$credentials ['active'] = 1;
			$remember = isset ( $credentials ['remember'] ) ? $credentials ['remember'] : false;
			// verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt ( $credentials ))
				return $this->jsonResponse ( 'invalid_password', null, Response::HTTP_UNAUTHORIZED );
		} else {
			if (! $credentials->active)
				return $this->jsonResponse ( 'user_is_not_activated', null, Response::HTTP_UNAUTHORIZED );
			if (! $token = JWTAuth::fromUser ( $credentials ))
				return $this->jsonResponse ( 'could_not_create_token', null, Response::HTTP_UNAUTHORIZED );
		}
		echo $token;
		static::setToken ( $token );
		static::setUser ( JWTAuth::authenticate ( $token ) );
		return $this->jsonResponse ( 'login_successfully' );
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
		JWTAuth::invalidate ( static::token () );
		static::setToken ( Config::INVALID_TOKEN );
		static::setUser ( User::getGuest () );
		return $this->jsonResponse ( 'logged_out' );
	}
}
