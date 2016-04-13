<?php

namespace App\IM\Models\User\Traits;

use App\User;
use Exception;
use App\IM\Configs;

trait Follower
{
	/**
	 * Return the users that follow the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function followers() {
		return $this->belongsToMany ( 'App\User', 'user_follower', 'follower_id', 'user_id' )->where ( 'users.active', '=', 1 );
	}
	/**
	 * Return the users that the user follows
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function following() {
		return $this->belongsToMany ( 'App\User', 'user_follower', 'user_id', 'follower_id' )->where ( 'users.active', '=', 1 );
	}
	public function follow(User $user) {
		try {
			$this->following ()->attach ( $user->id, [ 
					'active' => Configs::FOLLOWER_REQUESTED 
			] );
		} catch ( Exception $e ) {
			return $e;
		}
	}
	public function unfollow(User $user) {
		try {
			$this->following ()->detach ( $user->id );
		} catch ( Exception $e ) {
			return $e;
		}
	}
	public function acceptFollower(User $user) {
		try {
			$this->followers ()->updateExistingPivot ( $user->id, [ 
					'active' => Configs::FOLLOWER_REQUEST_ACCEPTED 
			] );
		} catch ( Exception $e ) {
			return $e;
		}
	}
	public function refuseFollower(User $user) {
		try {
			$this->followers ()->updateExistingPivot ( $user->id, [ 
					'active' => Configs::FOLLOWER_REQUEST_REFUSED 
			] );
		} catch ( Exception $e ) {
			return $e;
		}
	}
}
