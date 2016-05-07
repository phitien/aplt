<?php

namespace App\Ezsell\Models;

class Like extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'user_id',
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
	public function parent() {
		return $this->belongsTo ( 'App\Ezsell\Models\Item', 'parent_id', 'id' );
	}
}
