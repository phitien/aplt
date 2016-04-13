<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
	public $timestamps = false;
	protected $table = 'groups';
	protected $primaryKey = 'id';
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'name',
			'avatar',
			'cover',
			'status',
			'quote',
			'description',
			'json',
			'active' 
	];
	protected $hidden = [ 
			'active' 
	];
	/**
	 */
	public function users() {
		return $this->belongsToMany ( 'App\User', 'user_group', 'group_id', 'user_id' );
	}
	/**
	 */
	public function roles() {
		return $this->belongsToMany ( 'App\IM\Models\Role', 'group_role', 'group_id', 'role_id' );
	}
	/**
	 */
	public function actions() {
		return $this->belongsToMany ( 'App\IM\Models\Action', 'group_action', 'group_id', 'action_id' );
	}
}
