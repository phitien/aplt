<?php

namespace App\IM\Controllers;

use App\IM\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller {
	protected $_im_middlewares = [ 
			'im.authentication' 
	];
	protected $_im_middlewaresOptions = [ ];
	protected $_im_middlewaresExceptOption = [ ];
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function profile() {
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( null, $this->_user );
	}
	/**
	 * Return the authenticated user
	 *
	 * @return Response
	 */
	public function updateProfile(Request $request) {
		$data = $request->all ();
		unset ( $data ['name'] );
		unset ( $data ['email'] );
		unset ( $data ['password'] );
		$this->_user->fill ( $data );
		$this->_user->save ();
		// the token is valid and we have found the user via the sub claim
		return $this->jsonResponse ( null, $this->_user );
	}
}
