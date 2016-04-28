<?php

namespace App\Ezsell\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;
use App\Ezsell\Config\Config;

trait AccountTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiPassword ( $request );
		} else {
			return $this->showPassword ( $request );
		}
	}
	protected function apiPassword(Request $request) {
		$data = $request->only ( 'current_password', 'password', 'password_confirmation' );
		$response = static::apiCallPassword ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( View::make ( 'ok.password', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ) );
		} else {
			return $this->response ( View::make ( 'ko.password', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	protected function showPassword(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->response ( View::make ( 'password' ) );
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function email(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiEmail ( $request );
		} else {
			return $this->showEmail ( $request );
		}
	}
	protected function apiEmail(Request $request) {
		$data = $request->only ( 'current_password', 'email', 'email_confirmation' );
		$response = static::apiCallEmail ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( View::make ( 'ok.email', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ) );
		} else {
			return $this->response ( View::make ( 'ko.email', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	protected function showEmail(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->response ( View::make ( 'email' ) );
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function account(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiAccount ( $request );
		} else {
			return $this->showAccount ( $request );
		}
	}
	protected function apiAccount(Request $request) {
		$data = $request->only ( 'current_password', 'name' );
		$response = static::apiCallAccount ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( View::make ( 'ok.account', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ) );
		} else {
			return $this->response ( View::make ( 'ko.account', [ 
					'data' => json_decode ( $response->getBody (), true ) 
			] ), $response->getStatusCode () );
		}
	}
	protected function showAccount(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->response ( View::make ( 'account' ) );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function reset(Request $request) {
		// TODO
	}
}
