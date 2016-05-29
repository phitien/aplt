<?php

namespace App\Shared\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Shared\Models\User\Traits\ExtensionTrait;
use App\Shared\Models\User\Traits\RoleTrait;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
	/**
	 * Traits
	 */
	use Authenticatable, Authorizable, CanResetPassword;
	/**
	 * Traits
	 */
	use ExtensionTrait, RoleTrait;
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
			'json',
			'followers',
			'following' 
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
	 *
	 * {@inheritDoc}
	 *
	 * @see \Illuminate\Database\Eloquent\Model::toArray()
	 */
	public function toArray() {
		$attributes = parent::toArray ();
		return array_merge ( $attributes, [ 
				'extension' => $this->extension ()->all (),
				'displayname' => $this->getDisplayName () 
		] );
	}
	protected function getDisplayName() {
		return $this->alias ? $this->alias : 

		($this->first_name ? $this->first_name . $this->last_name ? " {$this->last_name}" : '' : $this->name);
	}
	/**
	 * Override save function to avoid save user data, the saving will be done via rest service
	 *
	 * @return false
	 */
	public function save(array $options = []) {
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
}
