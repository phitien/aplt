<?php

namespace App\Platform\Models;

class CatDetail extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'location_id',
			'active',
			'name',
			'title',
			'description',
			'avatar',
			'cover',
			'tags',
			'options',
			'bits' 
	];
	protected $hidden = [ 
			'tags',
			'options',
			'bits',
			'active',
			'created_at',
			'updated_at',
			'deleted_at' 
	];
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
		return $this->belongsTo ( 'App\Platform\Models\Cat', 'parent_id', 'id' );
	}
	public function location() {
		return $this->belongsTo ( 'App\Platform\Models\Place', 'location_id', 'id' );
	}
}
