<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Action extends Model {
	/**
	 *
	 * @var bool $timestamps
	 */
	public $timestamps = false;
	/**
	 *
	 * @var string $table
	 */
	protected $table = 'actions';
	/**
	 *
	 * @var string $primaryKey
	 */
	protected $primaryKey = 'id';
	/**
	 *
	 * @var array
	 */
	protected $guarded = [ 
			'id' 
	];
	/**
	 *
	 * @var array $fillable
	 */
	protected $fillable = [ 
			'code',
			'name',
			'description' 
	];
	/**
	 *
	 * @var array $hidden
	 */
	protected $hidden = [ ];
	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() {
		return $this->belongsToMany ( 'App\IM\Models\Role', 'role_action', 'action_id', 'role_id' );
	}
	/**
	 *
	 * @param string $code        	
	 * @return Action
	 */
	public static function getAction($code) {
		try {
			return static::where ( 'code', '=', $code )->first ();
		} catch ( Exception $e ) {
		}
		return null;
	}
}
