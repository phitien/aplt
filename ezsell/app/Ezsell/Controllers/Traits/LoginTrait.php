<?php

namespace App\Ezsell\Controllers\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use View;
use Illuminate\Support\Facades\Redirect;

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
		$response = $this->doLogin ( $credentials );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->redirect ( static::getRedirectUri () );
		} else {
			$data = json_decode ( $response->getBody (), true );
			return $this->response ( View::make ( 'login', [ 
					'appMessage' => "Hỏng rồi, không login được, lý do vì {$data['message']}. Thử lại phát đi" 
			] ), $response->getStatusCode () );
		}
	}
	protected function showLogin(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->redirect ();
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin(array $credentials = []) {
		return static::apiCallLogin ( $credentials );
	}
	/**
	 * Logout
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout() {
		return $this->doLogout ();
	}
	/**
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogout() {
		$response = static::apiCallLogout ();
		static::setToken ( Config::INVALID_TOKEN );
		return $this->redirect ();
	}
}
