<?php

namespace App\Platform\Models;

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
	public function item() {
		return $this->belongsTo ( 'App\Platform\Models\Item', 'parent_id', 'id' );
	}
}
