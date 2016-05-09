<?php

namespace App\Ezsell\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;

trait  ProfileTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function profile(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->saveProfile ( $request );
		} else {
			return $this->showProfile ( $request );
		}
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function showProfile(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'login' ) );
		else
			return $this->response ( View::make ( 'profile' ) );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function saveProfile(Request $request) {
		$data = $request->request->all (); // only get post data
		if ($msg = $this->validateProfileData ( $data )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$response = static::apiCallUpdateProfile ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'deactivate', [ 
					'appMessage' => "Hehe update ok rồi đấy :)." 
			] ) );
		} else {
			$data = json_decode ( $response->getBody (), true );
			return $this->response ( View::make ( 'deactivate', [ 
					'appMessage' => "Hỏng rồi, update có vài lỗi, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function profilex(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->saveProfileEx ( $request );
		} else {
			return $this->getProfileEx ( $request );
		}
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function getProfileEx(Request $request) {
		return $this->jsonResponse ( 'profile_extension', static::getUser ()->extension ()->all () );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function saveProfileEx(Request $request) {
		static::getUser ()->fillEx ( $request->request->all () )->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( 'update_profile_extension_successfully', static::getUser ()->extension ()->all () );
	}
}
