<?php

namespace App\Ezsell\Models;

class Item extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'user_id',
			'parent_id',
			'location_id',
			'active',
			'title',
			'description',
			'is_selling',
			'is_new',
			'originalprice',
			'saleprice',
			'nowprice',
			'meetup_at',
			'meetup_details',
			'mailing_details',
			'groups',
			'tags',
			'options',
			'bits',
			'deleted_at' 
	];
	protected $hidden = [ ];
	protected $dates = [ ];
	protected $casts = [ 
			'active' => 'boolean',
			'is_selling' => 'boolean',
			'is_new' => 'boolean',
			'options' => 'array' 
	];
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Illuminate\Database\Eloquent\Model::toArray()
	 */
	public function toArray() {
		$attributes = parent::toArray ();
		$user = static::getUser ();
		$like = $this->likes ()->where ( 'user_id', $user->id )->first ();
		return array_merge ( $attributes, [ 
				'code' => $this->code (),
				'images' => $this->images,
				'likes' => $this->likes ()->count (),
				'liked' => ($like ? true : false),
				'comments' => $this->comments ()->count () 
		] );
	}
	public function code() {
		return static::encrypt ( $this->id );
	}
	public function cat() {
		return $this->belongsTo ( 'App\Ezsell\Models\Cat', 'parent_id', 'id' );
	}
	public function location() {
		return $this->belongsTo ( 'App\Ezsell\Models\Place', 'location_id', 'id' );
	}
	public function images() {
		return $this->hasMany ( 'App\Ezsell\Models\Image', 'parent_id', 'id' );
	}
	public function comments() {
		return $this->hasMany ( 'App\Ezsell\Models\Comment', 'parent_id', 'id' );
	}
	public function likes() {
		return $this->hasMany ( 'App\Ezsell\Models\Like', 'parent_id', 'id' );
	}
	public function prices() {
		return $this->hasMany ( 'App\Ezsell\Models\Price', 'parent_id', 'id' );
	}
	public static function create(array $attributes = []) {
		$model = parent::create ( $attributes );
		return $model;
	}
}
