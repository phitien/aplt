<?php

namespace App\Media\Models;

class Resource extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'user_id',
			'code',
			'path' 
	];
	protected $hidden = [ ];
	protected $dates = [ 
			'created_at',
			'updated_at',
			'deleted_at' 
	];
	protected $casts = [ ];
}
