<?php

namespace App\Platform\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;

trait  LoginTrait {
	/**
	 * Return a JWT
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request) {
		return $this->process ( 'login', func_get_args () );
	}
	protected function ppostLogin(Request $request) {
		return $this->doLogin ( $request );
	}
	protected function pajaxpostLogin(Request $request) {
		return $this->doLogin ( $request );
	}
	protected function pgetLogin(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
		else
			return $this->redirect ();
	}
	protected function pajaxgetLogin(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin(Request $request) {
		$response = static::apiCallLogin ( $request->only ( 'email', 'password' ) );
		
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->jsonResponse ( 'login_successfully', $this->getPageResponseData ()->setType ( 'HomePage' ) );
			return $this->redirect ( static::getRedirectUri () );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			if ($request->ajax ()) {
				return $this->jsonResponse ( 'login_page', $this->getPageResponseData ()->setType ( 'LoginPage' )->setAppMessage ( $this->getTransMessage ( 'messages.sentences.login_failed', $data ) ) );
			}
			return $this->response ( view ( 'base', $this->getPageResponseData ()->setType ( 'LoginPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.login_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	/**
	 * Logout
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request) {
		return $this->doLogout ( $request );
	}
	/**
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogout(Request $request) {
		static::apiCallLogout ();
		static::setToken ( null );
		static::setUser ( null );
		return $this->redirect ( '/' );
	}
}
