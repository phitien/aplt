<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use App\IM\Utils;

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
	/**
	 *
	 * Save the model and re-build App\IM\RolesActions class
	 *
	 * @return bool
	 */
	public function save(array $options = []) {
		$rs = parent::save ( $options );
		Utils::buildRolesActions ( Role::all () );
		return $rs;
	}
	/**
	 *
	 * Delete the model and re-build App\IM\RolesActions class
	 *
	 * @return bool
	 */
	public function delete() {
		$rs = parent::delete ();
		Utils::buildRolesActions ( Role::all () );
		return $rs;
	}
}
