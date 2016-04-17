<?php

namespace App\IM\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;

trait  ProfileTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
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
	 * @param Request $request        	
	 * @return Response
	 */
	protected function getProfile(Request $request) {
		return $this->jsonResponse ( 'profile', $this->_user );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	protected function saveProfile(Request $request) {
		$data = $request->request->all (); // only get post data
		unset ( $data ['name'] );
		unset ( $data ['email'] );
		unset ( $data ['password'] );
		$this->_user->fill ( $data );
		$this->_user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( 'update_profile_successfully', $this->_user );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
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
	 * @param Request $request        	
	 * @return Response
	 */
	protected function getProfileEx(Request $request) {
		return $this->jsonResponse ( 'profile_extension', $this->_user->extension ()->all () );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	protected function saveProfileEx(Request $request) {
		$this->_user->fillEx ( $request->request->all () )->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( 'update_profile_extension_successfully', $this->_user->extension ()->all () );
	}
}
