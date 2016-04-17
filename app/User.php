<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Crypt;
use DateTime;
use App\IM\Models\User\Traits\RoleTrait;
use App\IM\Models\User\Traits\ActionTrait;
use App\IM\Models\User\Traits\ExtensionTrait;
use App\IM\Models\User\Traits\FollowerTrait;

class User extends Authenticatable {
	/**
	 * Traits
	 */
	use ExtensionTrait, RoleTrait, ActionTrait, FollowerTrait;
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
			'baseUrl' 
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [ 
			'id',
			'json',
			'active',
			'activationCode',
			'baseUrl',
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
		$user = parent::create ( $attributes );
		$user->createActivationCode ();
		return $user;
	}
	/**
	 *
	 * @param string $activationCode        	
	 * @return bool
	 */
	public static function decodeActivationCode($activationCode) {
		$key = Crypt::decrypt ( $activationCode );
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
	public function createActivationCode() {
		$timestamp = (new DateTime ())->getTimestamp ();
		$key = "{{$this->id}}-{{$this->email}}-{{$timestamp}}-{{$this->baseUrl}}";
		$this->activationCode = Crypt::encrypt ( $key );
		$this->save ();
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
				'extension' => $this->extension ()->all (),
				'followers' => count ( $this->followers ),
				'following' => count ( $this->following ) 
		] );
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
}
