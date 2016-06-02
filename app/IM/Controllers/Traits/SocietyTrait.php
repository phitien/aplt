<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\IM\Models\User;

trait SocietyTrait {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function followers(Request $request) {
		return $this->jsonResponse ( 'get_followers_successfully', static::getUser ()->followers );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function following(Request $request) {
		return $this->jsonResponse ( 'get_following_successfully', static::getUser ()->following );
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
		if (static::getUser ()->follow ( $user ))
			return $this->jsonResponse ( 'follow_successfully', static::getUser () );
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
		if (static::getUser ()->unfollow ( $user ))
			return $this->jsonResponse ( 'unfollow_successfully', static::getUser () );
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
		if (static::getUser ()->accept ( $user ))
			return $this->jsonResponse ( 'accept_successfully', static::getUser () );
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
		if (static::getUser ()->refuse ( $user ))
			return $this->jsonResponse ( 'refuse_successfully', static::getUser () );
		else
			return $this->jsonResponse ( 'refuse_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
}
