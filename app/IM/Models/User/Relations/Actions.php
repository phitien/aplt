<?php

namespace App\IM\Models\User\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;
use App\IM\Models\Action;

class Actions extends Relation {
	public function __construct($parent) {
		$instance = new Action ();
		$query = $instance->newQuery ()->select ( 'actions.*' )->distinct ()->from ( 'roles' )->join ( 'user_role', function ($join) {
			$join->on ( 'roles.id', '=', 'user_role.role_id' );
		} )->join ( 'role_action', function ($join) {
			$join->on ( 'user_role.role_id', '=', 'role_action.role_id' );
		} )->join ( 'actions', function ($join) {
			$join->on ( 'role_action.action_id', '=', 'actions.id' );
		} )->where ( 'user_role.user_id', '=', $parent->id );
		parent::__construct ( $query, $parent );
	}
	public function addConstraints() {
	}
	public function addEagerConstraints(array $models) {
	}
	public function initRelation(array $models, $relation) {
	}
	public function match(array $models, Collection $results, $relation) {
	}
	public function getResults() {
		return $this->query->get ();
	}
}
