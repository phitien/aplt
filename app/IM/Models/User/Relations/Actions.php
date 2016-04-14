<?php

namespace App\IM\Models\User\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;
use App\IM\Models\Action;
use App\User;
use App\IM\Config;

class Actions extends Relation {
	public function __construct(User $parent) {
		$instance = new Action ();
		$query = $instance->newQuery ();
		if (! $parent->isGuest ()) {
			$query = $query->select ( 'actions.*' )->distinct ()->from ( 'roles' )->join ( 'user_role', function ($join) {
				$join->on ( 'roles.id', '=', 'user_role.role_id' );
			} )->join ( 'role_action', function ($join) {
				$join->on ( 'user_role.role_id', '=', 'role_action.role_id' );
			} )->join ( 'actions', function ($join) {
				$join->on ( 'role_action.action_id', '=', 'actions.id' );
			} )->where ( 'user_role.user_id', '=', $parent->id );
		} else {
			$query = $query->select ( 'actions.*' )->distinct ()->join ( 'role_action', function ($join) {
				$join->on ( 'actions.id', '=', 'role_action.action_id' );
			} )->join ( 'roles', function ($join) {
				$join->on ( 'role_action.role_id', '=', 'roles.id' );
			} )->where ( 'roles.code', '=', Config::ROLE_GUEST );
		}
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
