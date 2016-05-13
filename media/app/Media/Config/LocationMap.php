<?php

namespace App\Media\Config;

use App\Media\Config\LocationMapTrait;

class LocationMap {
	
	/**
	 * TRAITS
	 */
	use LocationMapTrait;
	
	/**
	 *
	 * @return object
	 */
	public static function earth() {
		return ( object ) static::$maps ['EARTH'];
	}
	/**
	 *
	 * @param string $id        	
	 * @return array
	 */
	public static function tree($location, $desc = true) {
		if ($location) {
			$rs = [ 
					( int ) $location->id 
			];
			if ($location->parent_id) {
				array_push ( $rs, ( int ) $location->parent_id );
				if ($location->grandparent_id) {
					array_push ( $rs, ( int ) $location->grandparent_id );
					if ($location->great_grandparent_id) {
						array_push ( $rs, ( int ) $location->great_grandparent_id );
						if ($location->great_great_grandparent_id) {
							array_push ( $rs, ( int ) $location->great_great_grandparent_id );
						}
					}
				}
			}
			return $desc ? $rs : array_reverse ( $rs );
		}
		return [ ];
	}
	/**
	 *
	 * @param string $id        	
	 * @return array
	 */
	public static function find($id) {
		if ($id == 'EARTH' || $id == 1)
			return static::earth ();
		return ( object ) static::$maps ["l$id"];
	}
	/**
	 *
	 * @param string $q        	
	 * @return array
	 */
	public static function search($q) {
		return array_filter ( static::$maps, function ($item, $id) use ($q) {
			return strpos ( $item ['fullname'], $q ) !== false || strpos ( $item ['countryCode'], $q ) !== false;
		}, ARRAY_FILTER_USE_BOTH );
	}
}