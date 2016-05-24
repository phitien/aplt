<?php

namespace App\Platform\Traits;

use App\Platform\Config;
use App\Platform\Config\LocationMap;

trait LocationTrait {
	/**
	 *
	 * @return string encrypted location id
	 */
	public static function getLocationId() {
		if (! \App\Platform\Helper::$_location_id) {
			\App\Platform\Helper::$_location_id = static::param ( Config::LOCATION_KEY );
		}
		return \App\Platform\Helper::$_location_id;
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocationId($location_id) {
		\App\Platform\Helper::$_location_id = $location_id;
		\App\Platform\Helper::$_location = LocationMap::find ( \App\Platform\Helper::$_location_id );
	}
	/**
	 *
	 * @return Location
	 */
	public static function getLocation() {
		$location_id = static::getLocationId ();
		if (! \App\Platform\Helper::$_location) {
			\App\Platform\Helper::$_location = LocationMap::find ( $location_id );
		}
		return \App\Platform\Helper::$_location ? \App\Platform\Helper::$_location : LocationMap::earth ();
	}
}
