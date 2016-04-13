<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	public $timestamps = false;
	protected $table = 'roles';
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
		return $this->belongsToMany ( 'App\User', 'user_role', 'role_id', 'user_id' );
	}
	/**
	 */
	public function groups() {
		return $this->belongsToMany ( 'App\IM\Models\Group', 'group_role', 'role_id', 'group_id' );
	}
	/**
	 */
	public function actions() {
		return $this->belongsToMany ( 'App\IM\Models\Action', 'role_action', 'role_id', 'action_id' );
	}
}
