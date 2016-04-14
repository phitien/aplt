<?php

namespace App\IM\Models\User\Traits;

use App\User;
use Exception;
use App\IM\Config;
use App\IM\Models\User\Relations\Followers;
use App\IM\Models\User\Relations\Following;

trait FollowerTrait
{
	/**
	 * Return the users that follow the user
	 *
	 * @return Followers
	 */
	public function followers() {
		return (new Followers ( $this, $this->getBelongsToManyCaller () ))->where ( 'users.active', '=', 1 );
	}
	/**
	 * Return the users that the user follows
	 *
	 * @return Following
	 */
	public function following() {
		return (new Following ( $this, $this->getBelongsToManyCaller () ))->where ( 'users.active', '=', 1 );
	}
	/**
	 *
	 * @param User $user        	
	 */
	public function follow(User $user) {
		try {
			if (! $this->isGuest () && ! $user->isGuest ()) {
				$this->following ()->attach ( $user->id, [ 
						'active' => Config::FOLLOWER_REQUESTED 
				] );
			}
		} catch ( Exception $e ) {
			return $e;
		}
	}
	/**
	 *
	 * @param User $user        	
	 */
	public function unfollow(User $user) {
		try {
			if (! $this->isGuest () && ! $user->isGuest ()) {
				$this->following ()->detach ( $user->id );
			}
		} catch ( Exception $e ) {
			return $e;
		}
	}
	/**
	 *
	 * @param User $user        	
	 */
	public function acceptFollower(User $user) {
		try {
			if (! $this->isGuest () && ! $user->isGuest ()) {
				$this->followers ()->updateExistingPivot ( $user->id, [ 
						'active' => Config::FOLLOWER_REQUEST_ACCEPTED 
				] );
			}
		} catch ( Exception $e ) {
			return $e;
		}
	}
	/**
	 *
	 * @param User $user        	
	 */
	public function refuseFollower(User $user) {
		try {
			if (! $this->isGuest () && ! $user->isGuest ()) {
				$this->followers ()->updateExistingPivot ( $user->id, [ 
						'active' => Config::FOLLOWER_REQUEST_REFUSED 
				] );
			}
		} catch ( Exception $e ) {
			return $e;
		}
	}
}
