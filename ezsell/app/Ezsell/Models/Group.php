<?php

namespace App\Ezsell\Models;

class Cat extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
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
	public function place() {
		return $this->hasOne ( 'App\Ezsell\Models\Place', 'place_id', 'id' );
	}
}
