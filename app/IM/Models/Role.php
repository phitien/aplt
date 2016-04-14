<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model;
use App\IM\Config;

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
	 * Get supreme role
	 */
	private static $_supremeRole;
	public static function getSupreme() {
		if (null === static::$_supremeRole) {
			static::$_supremeRole = static::where ( 'code', '=', Config::ROLE_SUPREME )->first ();
		}
		return static::$_supremeRole;
	}
	/**
	 * Get manager role
	 */
	private static $_managerRole;
	public static function getManager() {
		if (null === static::$_managerRole) {
			static::$_managerRole = static::where ( 'code', '=', Config::ROLE_MANAGER )->first ();
		}
		return static::$_managerRole;
	}
	/**
	 * Get user role
	 */
	private static $_userRole;
	public static function getUser() {
		if (null === static::$_userRole) {
			static::$_userRole = static::where ( 'code', '=', Config::ROLE_USER )->first ();
		}
		return static::$_userRole;
	}
	/**
	 * Get guest role
	 */
	private static $_guestRole;
	public static function getGuest() {
		if (null === static::$_guestRole) {
			static::$_guestRole = static::where ( 'code', '=', Config::ROLE_GUEST )->first ();
		}
		return static::$_guestRole;
	}
	
	/**
	 *
	 * @param unknown $code        	
	 */
	public function addAction($code) {
		$action = Action::getAction ( $code );
		if (Config::canAddAction ( $this, $action ))
			$this->actions ()->attach ( $action->id );
	}
	/**
	 *
	 * @param unknown $code        	
	 */
	public function removeAction($code) {
		$action = Action::getAction ( $code );
		if (Config::canRemoveAction ( $this, $action ))
			$this->actions ()->detach ( $action->id );
	}
	/**
	 * Private clone method to prevent cloning of the instance
	 *
	 * @return void
	 */
	private function __clone() {
	}
}
