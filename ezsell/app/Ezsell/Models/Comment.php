<?php

namespace App\Ezsell\Models;

class Comment extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'text',
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
		return $this->hasOne ( 'App\Ezsell\Models\Item', 'parent_id', 'id' );
	}
}
