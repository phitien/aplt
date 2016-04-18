<?php

namespace App\Ezsell\Controllers\Traits;

use App\Ezsell\Config\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

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
		$data = [ ];
		return view ( 'login', $data );
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin($credentials) {
		$client = new Client ( [ 
				'cookie' => true 
		] );
		$response = $client->request ( 'POST', Config::IM_BASE_URL . '/login', [ 
				'form_params' => $credentials 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			$cookies = $response->getHeader ( 'set-cookie' );
			$json = json_decode ( $response->getBody (), true );
			$user = new User ( $json ['data'] );
			print_r ( $user->toArray () );
			foreach ( $cookies as $cookie ) {
				$cookie = SetCookie::fromString ( $cookie );
				if ($cookie->getName () == Config::IM_TOKEN_KEY) {
					$token = $cookie->getValue ();
					exit ();
					return $this->setResponseToken ( redirect ( '/' ), $this->setToken ( $token ) );
				}
			}
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
