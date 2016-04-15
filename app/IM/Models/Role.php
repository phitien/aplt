<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;
use App\IM\Config;
use App\IM\Utils;
use Illuminate\Support\Facades\Log;

class Role extends Model {
	/**
	 *
	 * @var bool
	 */
	public $timestamps = false;
	/**
	 *
	 * @var string
	 */
	protected $table = 'roles';
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
	public function users() {
		return $this->belongsToMany ( 'App\User', 'user_role', 'role_id', 'user_id' );
	}
	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function actions() {
		return $this->belongsToMany ( 'App\IM\Models\Action', 'role_action', 'role_id', 'action_id' );
	}
	/**
	 *
	 * @var Role
	 */
	private static $_supremeRole;
	/**
	 * Get supreme role
	 *
	 * @return Role
	 */
	public static function getSupreme() {
		if (null === static::$_supremeRole) {
			static::$_supremeRole = static::where ( 'code', '=', Config::ROLE_SUPREME )->first ();
		}
		return static::$_supremeRole;
	}
	/**
	 *
	 * @var Role
	 */
	private static $_managerRole;
	/**
	 * Get manager role
	 *
	 * @return Role
	 */
	public static function getManager() {
		if (null === static::$_managerRole) {
			static::$_managerRole = static::where ( 'code', '=', Config::ROLE_MANAGER )->first ();
		}
		return static::$_managerRole;
	}
	/**
	 *
	 * @var Role
	 */
	private static $_userRole;
	/**
	 * Get user role
	 *
	 * @return Role
	 */
	public static function getUser() {
		if (null === static::$_userRole) {
			static::$_userRole = static::where ( 'code', '=', Config::ROLE_USER )->first ();
		}
		return static::$_userRole;
	}
	/**
	 *
	 * @var Role
	 */
	private static $_guestRole;
	/**
	 * Get guest role
	 *
	 * @return Role
	 */
	public static function getGuest() {
		if (null === static::$_guestRole) {
			static::$_guestRole = static::where ( 'code', '=', Config::ROLE_GUEST )->first ();
		}
		return static::$_guestRole;
	}
	/**
	 *
	 * @return array
	 */
	public function getActions() {
		$items = [ ];
		$actions = $this->actions;
		foreach ( $actions as $action ) {
			array_push ( $items, $action->code );
		}
		return $items;
	}
	/**
	 *
	 * @param string $code        	
	 */
	public function addAction($code) {
		$action = Action::getAction ( $code );
		if ($this->canAddAction ( $action )) {
			$this->actions ()->attach ( $action->id );
			Utils::buildRolesActions ();
		}
	}
	/**
	 *
	 * @param Action $action        	
	 * @return bool
	 */
	protected function canAddAction(Action $action = null) {
		if (! $action)
			return false;
		$existance = $this->actions ()->where ( 'action_id', '=', $action->id )->first ();
		if ($existance) // already added
			return false;
		else
			return true;
	}
	/**
	 *
	 * @param string $code        	
	 */
	public function removeAction($code) {
		$action = Action::getAction ( $code );
		if ($this->canRemoveAction ( $action )) {
			$this->actions ()->detach ( $action->id );
			Utils::buildRolesActions ();
		}
	}
	/**
	 *
	 * @param Action $action        	
	 * @return boolean
	 */
	protected function canRemoveAction(Action $action = null) {
		if (! $action)
			return false;
		$existance = $this->actions ()->where ( 'action_id', '=', $action->id )->first ();
		if (! $existance) // not existing
			return false;
		else if (in_array ( $action->code, Config::getRoleCoreActions ( $this ) )) // exists and in the core actions
			return false;
		else // existing and not in the core actions
			return true;
	}
	
	/**
	 * Private clone method to prevent cloning of the instance
	 *
	 * @return void
	 */
	private function __clone() {
	}
	/**
	 *
	 * Save the model and re-build App\IM\RolesActions class
	 *
	 * @return bool
	 */
	public function save(array $options = []) {
		$rs = parent::save ( $options );
		Utils::buildRolesActions ();
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
		Utils::buildRolesActions ();
		return $rs;
	}
}
