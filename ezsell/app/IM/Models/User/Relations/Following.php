<?php

namespace App\IM\Models\User\Relations;

use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Following extends BelongsToMany {
	/**
	 * 
	 * @param User $user
	 * @param unknown $relation
	 */
	public function __construct(User $user, $relation) {
		$related = 'App\User';
		$table = 'user_follower';
		$foreignKey = 'user_id';
		$otherKey = 'follower_id';
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
