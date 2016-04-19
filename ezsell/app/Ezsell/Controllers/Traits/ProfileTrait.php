<?php

namespace App\Ezsell\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

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
			return $this->getProfile ( $request );
		}
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function getProfile(Request $request) {
		return $this->jsonResponse ( 'profile', $this->user () );
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
			$this->user ()->fill ( $data );
			$this->user ()->save ();
			// the token is valid and we have found the user via the sub claim
			return $this->jsonResponse ( 'update_profile_successfully', $this->user () );
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
		return $this->jsonResponse ( 'profile_extension', $this->user ()->extension ()->all () );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	protected function saveProfileEx(Request $request) {
		$this->user ()->fillEx ( $request->request->all () )->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( 'update_profile_extension_successfully', $this->user ()->extension ()->all () );
	}
}
