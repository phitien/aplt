<?php

namespace App\IM\Controllers;

use App\IM\Controllers\AuthenticableController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends AuthenticableController {
	/**
	 *
	 * @var string $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ ];
	/**
	 *
	 * @var string $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ ];
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function profile(Request $request) {
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( null, $this->_user );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function updateProfile(Request $request) {
		$data = $request->request->all (); // only get post data
		unset ( $data ['name'] );
		unset ( $data ['email'] );
		unset ( $data ['password'] );
		$this->_user->fill ( $data );
		$this->_user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( 'update_successfully', $this->_user );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function updateExInfo(Request $request) {
		$data = $request->request->all (); // only get post data
		$this->_user->fillEx ( $data );
		$this->_user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( 'update_successfully', $this->_user );
	}
}
