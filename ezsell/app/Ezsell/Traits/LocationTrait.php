<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config;
use App\Ezsell\Config\LocationMap;

trait LocationTrait {
	/**
	 *
	 * @return string encrypted location id
	 */
	public static function getLocationId() {
		if (! \App\Ezsell\Helper::$_location_id) {
			\App\Ezsell\Helper::$_location_id = static::param ( Config::LOCATION_KEY );
		}
		return \App\Ezsell\Helper::$_location_id;
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocationId($location_id) {
		\App\Ezsell\Helper::$_location_id = $location_id;
		\App\Ezsell\Helper::$_location = LocationMap::find ( \App\Ezsell\Helper::$_location_id );
	}
	/**
	 *
	 * @return Location
	 */
	public static function getLocation() {
		$location_id = static::getLocationId ();
		if (! \App\Ezsell\Helper::$_location) {
			\App\Ezsell\Helper::$_location = LocationMap::find ( $location_id );
		}
		return \App\Ezsell\Helper::$_location ? \App\Ezsell\Helper::$_location : LocationMap::earth ();
	}
}
