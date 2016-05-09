<?php

namespace App\Ezsell\Models;

class Group extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'location_id',
			'active',
			'title',
			'description',
			'avatar',
			'cover',
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
			'options' => 'array' 
	];
	public function location() {
		return $this->hasOne ( 'App\Ezsell\Models\Place', 'location_id', 'id' );
	}
}
