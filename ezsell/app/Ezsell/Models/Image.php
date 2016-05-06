<?php

namespace App\Ezsell\Models;

class Image extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'title',
			'description',
			'url',
			'options' 
	];
	protected $hidden = [ ];
	protected $dates = [ 
			'created_at',
			'updated_at' 
	];
	protected $casts = [ 
			'options' => 'array' 
	];
	public function parent() {
		return $this->hasOne ( 'App\Ezsell\Models\Item', 'parent_id', 'id' );
	}
}
