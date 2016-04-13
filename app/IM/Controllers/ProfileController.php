<?php

namespace App\IM\Controllers;

use JWTAuth;
use App\IM\Controllers\Controller;
use App\User;
use App\IM\Middleware\AuthMiddleware;
use Illuminate\Http\Request;

class ProfileController extends Controller {
	public function __construct() {
		$this->middleware ( [ 
				AuthMiddleware::class 
		], [ 
				'except' => [ ] 
		] );
	}
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function profile() {
		$user = JWTAuth::authenticate ( JWTAuth::getToken () );
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( null, $user );
	}
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function updateProfile(Request $request) {
		$user = JWTAuth::authenticate ( JWTAuth::getToken () );
		$data = $request->all ();
		unset ( $data ['email'] );
		unset ( $data ['password'] );
		$user->fill ( $data );
		$user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( null, $user );
	}
}
