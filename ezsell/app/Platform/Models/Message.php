<?php

namespace App\Platform\Models;

class Message extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'to_id',
			'from_id',
			'content',
			'status' 
	];
	protected $hidden = [ 
			'parent_id',
			'to_id',
			'from_id',
			'options',
			'item',
			'show_on_to',
			'show_on_from' 
	];
	protected $dates = [ ];
	protected $casts = [ 
			'options' => 'array' 
	];
	public function item() {
		return $this->belongsTo ( 'App\Platform\Models\Item', 'parent_id', 'id' );
	}
}
