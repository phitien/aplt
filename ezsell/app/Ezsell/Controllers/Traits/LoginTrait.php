<?php

namespace App\Ezsell\Controllers\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use View;

trait  LoginTrait {
	/**
	 * Return a JWT
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiLogin ( $request );
		} else {
			return $this->showLogin ( $request );
		}
	}
	protected function apiLogin(Request $request) {
		$credentials = $request->only ( 'email', 'password' );
		return $this->doLogin ( $credentials );
	}
	protected function showLogin(Request $request) {
		if ($this->token ()) {
		} else
			return $this->response ( View::make ( 'login' ) );
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin($credentials) {
		$response = $this->restful_post ( 'api/login', $credentials );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'index' ) );
		} else {
			return $this->response ( redirect ( '/' ) );
		}
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
		return $this->jsonResponse ( 'logged_out', null );
	}
}
