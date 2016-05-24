<?php

namespace App\Platform\Models;

class Location extends Model {
	public $timestamps = false;
	protected $guarded = [ ];
	protected $fillable = [ 
			'countryCode',
			'fullname',
			'id',
			'name',
			'parent_id',
			'parent_name',
			'grandparent_id',
			'grandparent_name',
			'great_grandparent_id',
			'great_grandparent_name' 
	];
	protected $hidden = [ ];
	protected $dates = [ ];
	protected $casts = [ ];
	public static function earth() {
		return static::where ( 'fcode', 'EARTH' )->first ();
	}
	public static function getCountry($countryCode) {
		return static::where ( 'countryCode', $countryCode )->first ();
	}
	public static function search($q) {
		return static::where ( 'fullname', 'LIKE', "%$q%" )->where ( 'fcode', 'NOT LIKE', "EARTH" )->get ();
	}
}
