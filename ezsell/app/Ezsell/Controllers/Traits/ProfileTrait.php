<?php

namespace App\Ezsell\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
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
			return $this->response ( View::make ( 'profile', [ 
					'user' => static::getUser () 
			] ) );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function saveProfile(Request $request) {
		try {
			$data = $request->request->all (); // only get post data
			unset ( $data ['name'] );
			unset ( $data ['email'] );
			unset ( $data ['password'] );
			if ($msg = $this->validateProfileData ( $data )) {
				return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
			}
			static::getUser ()->fill ( $data );
			static::getUser ()->save ();
			// the token is valid and we have found the user via the sub claim
			return $this->jsonResponse ( 'update_profile_successfully', static::getUser () );
		} catch ( Exception $e ) {
			return $this->jsonResponse ( 'update_profile_unsuccessfully', $e->getMessage (), Response::HTTP_BAD_REQUEST );
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
