<?php

namespace App\Platform\Controllers\Traits;

use App\Platform\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait  ProfileTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function profile(Request $request) {
		return $this->process ( 'profile', func_get_args () );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function pgetProfile(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
		else
			return $this->response ( view ( 'base', $this->getPageResponseDataNoBanner ()->setType ( 'ProfilePage' ) ) );
	}
	protected function pajaxgetProfile(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
		else
			return $this->jsonResponse ( 'profile', $this->getPageResponseDataNoBanner ()->setType ( 'ProfilePage' ) );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function ppostProfile(Request $request) {
		$data = $request->request->all (); // only get post data
		$response = static::apiCallUpdateProfile ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( view ( 'base', $this->getPageResponseDataNoBanner ()->setType ( 'ProfilePage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.profile_updated', $data ) ) ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseDataNoBanner ()->setType ( 'ProfilePage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.profile_update_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function profilex(Request $request) {
		return $this->process ( 'profilex', func_get_args () );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function pgetProfileEx(Request $request) {
		// TODO
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function ppostProfileEx(Request $request) {
		// TODO
	}
}
