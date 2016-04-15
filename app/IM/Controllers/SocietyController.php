<?php

namespace App\IM\Controllers;

use App\IM\Controllers\AuthenticableController;
use Illuminate\Http\Request;
use App\User;
use App\IM\Response\Status;

class SocietyController extends AuthenticableController {
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
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function followers(Request $request) {
		return $this->jsonResponse ( 'get_followers_successfully', $this->_user->followers );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function following(Request $request) {
		return $this->jsonResponse ( 'get_following_successfully', $this->_user->following );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function follow(Request $request) {
		$username = $request->get ( 'name' );
		$user = User::where ( 'name', '=', $username )->first ();
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User ' . $username . ' not found', Status::BadRequest );
		}
		if ($this->_user->follow ( $user ))
			return $this->jsonResponse ( 'follow_successfully', '' );
		else
			return $this->jsonResponse ( 'follow_unsuccessfully', 'Some error occurs.', Status::BadRequest );
	}
}
