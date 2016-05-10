<?php

namespace App\Ezsell\Models;

class Price extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'title',
			'description',
			'group',
			'group2',
			'options' 
	];
	protected $hidden = [ ];
	protected $dates = [ 
			'created_at',
			'updated_at',
			'deleted_at' 
	];
	protected $casts = [ 
			'options' => 'array' 
	];
	public function item() {
		return $this->belongsTo ( 'App\Ezsell\Models\Item', 'parent_id', 'id' );
	}
}
