<?php

namespace App\IM\Controllers;

use JWTAuth;
use App\IM\Controllers\Controller;
use App\User;
use App\IM\Middleware\AuthenticationMiddleware;
use Illuminate\Http\Request;

class ProfileController extends Controller {
	protected $_im_middlewares = [ 
			AuthenticationMiddleware::class 
	];
	protected $_im_middlewaresOptions = [ ];
	protected $_im_middlewaresExceptOption = [ ];
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
		unset ( $data ['name'] );
		unset ( $data ['email'] );
		unset ( $data ['password'] );
		$user->fill ( $data );
		$user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( null, $user );
	}
}
