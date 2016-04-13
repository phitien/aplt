<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model {
	public $timestamps = false;
	protected $table = 'actions';
	protected $primaryKey = 'id';
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'code',
			'name',
			'description' 
	];
	protected $hidden = [ ];
	/**
	 */
	public function users() {
		return $this->belongsToMany ( 'App\User', 'user_action', 'action_id', 'user_id' );
	}
	/**
	 */
	public function groups() {
		return $this->belongsToMany ( 'App\IM\Models\Group', 'group_action', 'action_id', 'group_id' );
	}
	/**
	 */
	public function roles() {
		return $this->belongsToMany ( 'App\IM\Models\Role', 'role_action', 'action_id', 'role_id' );
	}
}
