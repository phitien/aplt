<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;
use App\IM\Configs;
use Exception;

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
	public function actions() {
		return $this->belongsToMany ( 'App\IM\Models\Action', 'role_action', 'role_id', 'action_id' );
	}
	/**
	 *
	 * @param unknown $code        	
	 * @return null or Exception
	 */
	public function addAction($code) {
		try {
			$action = Action::where ( 'code', '=', $code )->firstOrFail ();
			if (Configs::canAddAction ( $this, $action ))
				$this->actions ()->attach ( $action->id );
		} catch ( Exception $e ) {
			return $e;
		}
	}
	/**
	 *
	 * @param unknown $code        	
	 * @return null or Exception
	 */
	public function removeAction($code) {
		try {
			$action = Action::where ( 'code', '=', $code )->firstOrFail ();
			if (Configs::canRemoveAction ( $this, $action ))
				$this->actions ()->detach ( $action->id );
		} catch ( Exception $e ) {
			return $e;
		}
	}
}
