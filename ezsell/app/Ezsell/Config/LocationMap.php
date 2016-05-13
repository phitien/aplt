<?php

namespace  App\Ezsell\Config ;
 
use App\Ezsell\Config\LocationMapTrait;

 class   LocationMap  {

	/**
	 * TRAITS
	 */
	use LocationMapTrait;








	/**
	 *
	 * @return  object
	 */
	public static function earth() {
		return static::$maps['EARTH'];
	}
	/**
	 *
	 * @param  string $id
	 * @return  array
	 */
	public static function tree($location) {
		if ($location) {
			$rs = [ 
					( int ) $location ['id'] 
			];
			if ($location ['parent_id']) {
				array_push ( $rs, ( int ) $location ['parent_id'] );
				if ($location ['grandparent_id']) {
					array_push ( $rs, ( int ) $location ['grandparent_id'] );
					if ($location ['great_grandparent_id']) {
						array_push ( $rs, ( int ) $location ['great_grandparent_id'] );
						if ($location ['great_great_grandparent_id']) {
							array_push ( $rs, ( int ) $location ['great_great_grandparent_id'] );
						}
					}
				}
			}
			return $rs;
		}
		return [ ];
	}
	/**
	 *
	 * @param  string $id
	 * @return  string
	 */
	public static function getName($id) {
		if ($id == 'EARTH' || $id == 1)
			return static::earth () ['fullname'];
		return static::$maps ["l$id"] ? static::$maps ["l$id"] ['fullname'] : '';
	}
	/**
	 *
	 * @param  string $id
	 * @return  array
	 */
	public static function find($id) {
		if ($id == 'EARTH' || $id == 1)
			return static::earth ();
		return static::$maps ["l$id"];
	}
	/**
	 *
	 * @param  string $q
	 * @return  array
	 */
	public static function search($q) {
		return array_filter(static::$maps, function($location, $id) use ($q) {
		    return strpos( $location['fullname'], $q ) !== false || strpos( $location['countryCode'], $q ) !== false;
		}, ARRAY_FILTER_USE_BOTH);
	}

}