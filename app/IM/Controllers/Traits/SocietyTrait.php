<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

trait SocietyTrait {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function followers(Request $request) {
		return $this->jsonResponse ( 'get_followers_successfully', $this->user ()->followers );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function following(Request $request) {
		return $this->jsonResponse ( 'get_following_successfully', $this->user ()->following );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function follow(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->user ()->follow ( $user ))
			return $this->jsonResponse ( 'follow_successfully', $this->user () );
		else
			return $this->jsonResponse ( 'follow_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function unfollow(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->user ()->unfollow ( $user ))
			return $this->jsonResponse ( 'unfollow_successfully', $this->user () );
		else
			return $this->jsonResponse ( 'unfollow_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function accept(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->user ()->accept ( $user ))
			return $this->jsonResponse ( 'accept_successfully', $this->user () );
		else
			return $this->jsonResponse ( 'accept_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function refuse(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->user ()->refuse ( $user ))
			return $this->jsonResponse ( 'refuse_successfully', $this->user () );
		else
			return $this->jsonResponse ( 'refuse_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
}
