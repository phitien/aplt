<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Crypt;
use DateTime;
use App\IM\Models\User\Traits\Role;
use App\IM\Models\User\Traits\Action;
use App\IM\Models\User\Traits\Extension;
use App\IM\Models\User\Traits\Follower;
use App\IM\Models\User\Traits\Following;

class User extends Authenticatable {
	/**
	 * Traits
	 */
	use Extension, Role, Action, Follower;
	/**
	 */
	protected $guarded = [ 
			'id',
			'activationCode',
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
			'avatar',
			'cover',
			'status',
			'quote',
			'description' 
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
			'password',
			'remember_token' 
	];
	
	/**
	 * Save a new model and return the instance.
	 *
	 * @param array $attributes        	
	 * @return static
	 */
	public static function create(array $attributes = []) {
		$user = parent::create ( $attributes );
		$user->getActivationCode ();
		return $user;
	}
	/**
	 *
	 * @param unknown $activationCode        	
	 */
	public static function activateUser($activationCode) {
		$key = Crypt::decrypt ( $activationCode );
		$pattern = '/\{(\d*)\}\-\{(.*)\}\-\{(\d+)\}/';
		preg_match ( $pattern, $key, $matches );
		if ($matches && count ( $matches ) == 4) {
			$date = new DateTime ();
			$timestamp = $date->getTimestamp ();
			
			$user = User::find ( $matches [1] );
			if ($user && $user->email == $matches [2]) {
				if (! $user->active) {
					if (! $user->activationLinkExpired ( $activationCode )) {
						$user->active = 1;
						$user->save ();
						return 1; // successful activated
					} else {
						return - 2; // link expired
					}
				} else {
					return 2; // already activated
				}
			}
		}
		return - 1; // activation code invalid
	}
	/**
	 *
	 * @param unknown $timestamp        	
	 * @param User $user        	
	 */
	protected function activationLinkExpired($activationCode) {
		return $this->activationCode != $activationCode;
	}
	/**
	 *
	 * @return activation code
	 */
	public function getActivationCode() {
		$date = new DateTime ();
		$timestamp = $date->getTimestamp ();
		$key = "{{$this->id}}-{{$this->email}}-{{$timestamp}}";
		$this->activationCode = Crypt::encrypt ( $key );
		$this->save ();
		return $this->activationCode;
	}
	/**
	 */
	public function isActivated() {
		return $this->active ? true : false;
	}
	public function toArray() {
		$attributes = parent::toArray ();
		return array_merge ( $attributes, [ 
				'extension' => $this->extension ()->all (),
				'roles' => $this->roles,
				'actions' => $this->actions,
				'followers' => count ( $this->followers ),
				'following' => count ( $this->following ) 
		] );
	}
	/**
	 * override save function to save json property
	 */
	public function save(array $options = []) {
		$this->json = $this->extension ()->toJson ();
		return parent::save ( $options );
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Illuminate\Database\Eloquent\Model::fill()
	 */
	public function fill(array $attributes) {
		if ($attributes && isset ( $attributes ['extension'] )) {
			$extension = $attributes ['extension'];
			$this->extension ()->fill ( $extension );
		}
		return parent::fill ( $attributes );
	}
}
