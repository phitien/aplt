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
				try {
					$this->following ()->attach ( $user->id, [ 
							'active' => Config::FOLLOWER_REQUESTED 
					] );
					return true;
				} catch ( Exception $e ) {
					$this->following ()->updateExistingPivot ( $user->id, [ 
							'active' => Config::FOLLOWER_REQUESTED 
					] );
					return true;
				}
			}
		} catch ( Exception $e ) {
		}
		return false;
	}
	/**
	 *
	 * @param User $user        	
	 */
	public function unfollow(User $user) {
		try {
			if (! $this->isGuest () && ! $user->isGuest ()) {
				$this->following ()->detach ( $user->id );
				return true;
			}
		} catch ( Exception $e ) {
		}
		return false;
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
				return true;
			}
		} catch ( Exception $e ) {
		}
		return false;
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
				return true;
			}
		} catch ( Exception $e ) {
		}
		return false;
	}
}
