<?php

namespace App\Ezsell\Models;

use App\Ezsell\Config\LocationMap;

class Cat extends Model {
	public $timestamps = false;
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'code',
			'active',
			'atomic',
			'order' 
	];
	protected $hidden = [ 
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
			'atomic' => 'boolean' 
	];
	public function toArray() {
		$attributes = parent::toArray ();
		$location = static::getLocation ();
		if ($location) {
			$ids = LocationMap::tree ( $location, false );
			foreach ( $ids as $id ) {
				if ($id) {
					$details = $this->details ()->where ( 'location_id', $id )->first ();
					if ($details && ! $details->active) {
						$details = null;
						break;
					}
				}
			}
			return array_merge ( $attributes, [ 
					'details' => $details,
					'children' => $this->children 
			] );
		} else {
			return array_merge ( $attributes, [ 
					'children' => $this->children 
			] );
		}
		return $attributes;
	}
	public function details() {
		return $this->hasMany ( 'App\Ezsell\Models\CatDetail', 'parent_id', 'id' );
	}
	public function parent() {
		return $this->belongsTo ( 'App\Ezsell\Models\Cat', 'parent_id', 'id' );
	}
	public function children() {
		return $this->hasMany ( 'App\Ezsell\Models\Cat', 'parent_id', 'id' );
	}
	public function items() {
		return $this->hasMany ( 'App\Ezsell\Models\Item', 'parent_id', 'id' );
	}
	public static function getHierarchy() {
		$hierarchy = static::where ( 'parent_id', null )->where ( 'active', 1 )->get ();
		return $hierarchy;
	}
}
