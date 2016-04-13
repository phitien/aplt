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
			'description',
			'active' 
	];
	protected $hidden = [ ];
	/**
	 * The users that have the role.
	 */
	public function users() {
		return $this->belongsToMany ( 'User', 'user_role', 'role_id', 'user_id' );
	}
}
