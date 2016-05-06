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
			'place_id',
			'active',
			'title',
			'description',
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
			'is_new' => 'boolean',
			'options' => 'array' 
	];
	public function parent() {
		return $this->hasOne ( 'App\Ezsell\Models\Cat', 'parent_id', 'id' );
	}
	public function place() {
		return $this->hasOne ( 'App\Ezsell\Models\Place', 'place_id', 'id' );
	}
}
