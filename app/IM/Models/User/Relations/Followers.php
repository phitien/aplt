<?php

namespace App\IM\Models\User\Relations;

use App\IM\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Followers extends BelongsToMany {
	/**
	 *
	 * @param User $user        	
	 * @param unknown $relation        	
	 */
	public function __construct(User $user, $relation) {
		$related = 'App\IM\Models\User';
		$table = 'user_follower';
		$foreignKey = 'follower_id';
		$otherKey = 'user_id';
		$instance = new $related ();
		$otherKey = $otherKey ?: $instance->getForeignKey ();
		$query = $instance->newQuery ();
		parent::__construct ( $query, $user, $table, $foreignKey, $otherKey, $relation );
	}
	public function getResults() {
		if ($this->parent->isGuest ()) {
			return [ ];
		} else {
			return parent::getResults ();
		}
	}
}
