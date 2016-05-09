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
			'bits' 
	];
	protected $hidden = [ ];
	protected $dates = [ 
			'created_at',
			'updated_at',
			'deleted_at' 
	];
	protected $casts = [ 
			'active' => 'boolean',
			'is_selling' => 'boolean',
			'is_new' => 'boolean',
			'options' => 'array' 
	];
	public function parent() {
		return $this->belongsTo ( 'App\Ezsell\Models\Cat', 'parent_id', 'id' );
	}
	public function location() {
		return $this->belongsTo ( 'App\Ezsell\Models\Place', 'location_id', 'id' );
	}
	public function images() {
		return $this->hasMany ( 'App\Ezsell\Models\Image', 'parent_id', 'id' );
	}
	public function commnents() {
		return $this->hasMany ( 'App\Ezsell\Models\Comment', 'parent_id', 'id' );
	}
	public function likes() {
		return $this->hasMany ( 'App\Ezsell\Models\Like', 'parent_id', 'id' );
	}
	public function prices() {
		return $this->hasMany ( 'App\Ezsell\Models\Price', 'parent_id', 'id' );
	}
}
