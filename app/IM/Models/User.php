<?php

namespace App\IM\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\IM\Models\User\Traits\ExtensionTrait;
use App\IM\Models\User\Traits\RoleTrait;
use App\IM\Models\User\Traits\ActionTrait;
use App\IM\Models\User\Traits\SocietyTrait;
use DateTime;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
	/**
	 * Traits
	 */
	use Authenticatable, Authorizable, CanResetPassword;
	/**
	 * Traits
	 */
	use ExtensionTrait, RoleTrait, ActionTrait, SocietyTrait;
	/**
	 * Table name
	 *
	 * @var unknown $table
	 */
	protected $table = 'users';
	/**
	 *
	 * @var array
	 */
	protected $guarded = [ 
			'id',
			'created_at',
			'updated_at' 
	];
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 
			'id',
			'name',
			'email',
			'password',
			'second_email',
			'first_name',
			'last_name',
			'middle_name',
			'alias',
			'birthday',
			'gender',
			'marital_status',
			'mobile',
			'country',
			'city',
			'address',
			'postcode',
			'avatar',
			'cover',
			'status',
			'quote',
			'description',
			'baseUrl',
			'json' 
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [ 
			'active',
			'activationCode',
			'password',
			'remember_token' 
	];
	
	/**
	 * Save a new model and return the instance.
	 *
	 * @param array $attributes        	
	 * @return User
	 */
	public static function create(array $attributes = []) {
		$attributes = [ 
				'name' => isset ( $attributes ['name'] ) ? $attributes ['name'] : uniqid ( 'IM' ),
				'email' => $attributes ['email'],
				'password' => static::encode ( $attributes ['password'] ),
				'baseUrl' => static::getBaseUrl (),
				'active' => 0 
		];
		$user = parent::create ( $attributes );
		$user->generateActivationCode ();
		return $user;
	}
	/**
	 *
	 * @param string $activationCode        	
	 * @return bool
	 */
	public static function decodeActivationCode($activationCode) {
		$key = static::decrypt ( $activationCode );
		$pattern = '/\{(\d+)\}\-\{(.+)\}\-\{(\d+)\}-\{(.*)\}/';
		preg_match ( $pattern, $key, $matches );
		if ($matches && count ( $matches ) == 5) {
			return $matches;
		}
		return false;
	}
	/**
	 *
	 * @param string $activationCode        	
	 * @return bool
	 */
	public function activate($activationCode) {
		if (! $this->activationLinkExpired ( $activationCode )) {
			$this->active = 1;
			$this->activationCode = '';
			$this->save ();
			return true;
		}
		return false;
	}
	/**
	 *
	 * @return bool
	 */
	public function deactivate() {
		$this->active = 0;
		$this->activationCode = '';
		$this->save ();
		return true;
	}
	/**
	 *
	 * @param string $activationCode        	
	 * @return boolean
	 */
	protected function activationLinkExpired($activationCode) {
		return $this->activationCode != $activationCode;
	}
	/**
	 *
	 * @return string activation code
	 */
	public function generateActivationCode() {
		$timestamp = (new DateTime ())->getTimestamp ();
		$key = "{{$this->id}}-{{$this->email}}-{{$timestamp}}-{{$this->baseUrl}}";
		$this->activationCode = static::encrypt ( $key );
		$this->active = 0;
		$this->save ();
		return $this->activationCode;
	}
	/**
	 *
	 * @return boolean
	 */
	public function isActivated() {
		return $this->active ? true : false;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Illuminate\Database\Eloquent\Model::toArray()
	 */
	public function toArray() {
		$attributes = parent::toArray ();
		
		return array_merge ( $attributes, [ 
				'displayname' => $this->getDisplayName (),
				'extension' => $this->extension ()->all (),
				'followers' => $this->followers->lists('id'),
				'following' => $this->following->lists('id') 
		] );
	}
	protected function getDisplayName() {
		return $this->alias ? $this->alias : 

		($this->first_name ? $this->first_name . $this->last_name ? " {$this->last_name}" : '' : $this->name);
	}
	/**
	 * Override save function to save json property
	 *
	 * @return User
	 */
	public function save(array $options = []) {
		if (! $this->isGuest ()) {
			$this->json = $this->extension ()->toJson ();
			return parent::save ( $options );
		}
		return false;
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Illuminate\Database\Eloquent\Model::fill()
	 */
	public function fill(array $attributes) {
		if ($attributes && isset ( $attributes ['extension'] )) {
			$this->fillEx ( $attributes ['extension'] );
		}
		return parent::fill ( $attributes );
	}
	/**
	 *
	 * @param string $email        	
	 */
	public function changeEmail($email) {
		if (! $this->isGuest ()) {
			$this->email = $email;
			$this->generateActivationCode ();
		}
		return $email;
	}
	/**
	 *
	 * @param string $password        	
	 */
	public function changePassword($password) {
		if (! $this->isGuest ()) {
			$this->password = static::encode ( $password );
			$this->save ();
		}
		return $password;
	}
	/**
	 *
	 * @param string $name        	
	 */
	public function changeName($name) {
		if (! $this->isGuest ()) {
			$this->name = $name;
			$this->save ();
			return $this->name;
		}
	}
}
