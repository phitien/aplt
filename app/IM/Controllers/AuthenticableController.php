<?php

namespace App\IM\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\IM\Controllers\Controller;
use App\IM\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticableController extends Controller {
	/**
	 *
	 * @var string $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'login' 
			] 
	];
	/**
	 *
	 * @var string $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ ];
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
		$credentials ['active'] = 1;
		try {
			// verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt ( $credentials )) {
				return $this->jsonResponse ( 'invalid_credentials', null, Status::Unauthorized );
			}
		} catch ( Exception $e ) {
			// something went wrong
			return $this->jsonResponse ( 'could_not_create_token', null, Status::InternalServerError );
		}
		// if no errors are encountered we can return a JWT
		return $this->jsonResponse ( 'login_successfully', $token );
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
		JWTAuth::invalidate ( JWTAuth::getToken () );
		return $this->jsonResponse ( 'logged_out', null );
	}
	/**
	 * Refresh
	 *
	 * @return Response
	 */
	public function refresh() {
		try {
			if (! $token = JWTAuth::refresh ( JWTAuth::getToken () )) {
				return $this->jsonResponse ( 'token_invalid', null, Status::Unauthorized );
			}
		} catch ( Exception $e ) {
			return $this->jsonResponse ( 'token_invalid', null, Status::Unauthorized );
		}
		// if no errors are encountered we can return a JWT
		return $this->jsonResponse ( 'token_renewed', $token );
	}
}
