<?php

namespace App\IM\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\IM\Controllers\Controller;
use App\IM\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticateController extends Controller {
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
	 * Logout
	 *
	 * @return Response
	 */
	public function logout() {
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
