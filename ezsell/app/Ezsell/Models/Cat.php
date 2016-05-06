<?php

namespace App\Ezsell\Models;

class Cat extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'place_id',
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
	public function parent() {
		return $this->hasOne ( 'App\Ezsell\Models\Cat', 'parent_id', 'id' );
	}
	public function children() {
		return $this->hasMany ( 'App\Ezsell\Models\Cat', 'id', 'parent_id' );
	}
	public function place() {
		return $this->hasOne ( 'App\Ezsell\Models\Place', 'place_id', 'id' );
	}
}
