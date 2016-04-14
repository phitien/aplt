<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

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
	public function roles() {
		return $this->belongsToMany ( 'App\IM\Models\Role', 'role_action', 'action_id', 'role_id' );
	}
	/**
	 *
	 * @param unknown $code        	
	 */
	public static function getAction($code) {
		try {
			return static::where ( 'code', '=', $code )->first ();
		} catch ( Exception $e ) {
		}
		return null;
	}
}
