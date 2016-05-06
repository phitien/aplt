<?php

namespace App\Ezsell\Models;

class Place extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'active',
			'geonameId',
			'name',
			'toponymName',
			'countryCode',
			'options' 
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
		return $this->hasOne ( 'App\Ezsell\Models\Place', 'parent_id', 'id' );
	}
	public function children() {
		return $this->hasMany ( 'App\Ezsell\Models\Place', 'id', 'parent_id' );
	}
}
