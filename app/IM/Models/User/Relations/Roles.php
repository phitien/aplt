<?php

namespace App\IM\Models\User\Relations;

use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\IM\Models\Role;

class Roles extends BelongsToMany {
	public function __construct(User $user, $relation) {
		$related = 'App\IM\Models\Role';
		$table = 'user_role';
		$foreignKey = 'user_id';
		$otherKey = 'role_id';
		$instance = new $related ();
		$otherKey = $otherKey ?: $instance->getForeignKey ();
		$query = $instance->newQuery ();
		parent::__construct ( $query, $user, $table, $foreignKey, $otherKey, $relation );
	}
	public function getResults() {
		if ($this->parent->isGuest ()) {
			return [ 
					Role::getGuest () 
			];
		} else {
			return parent::getResults ();
		}
	}
}
