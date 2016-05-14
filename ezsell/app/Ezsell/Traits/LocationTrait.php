<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config\Config;
use App\Ezsell\Config\LocationMap;

trait LocationTrait
{
	use ResponseTrait;
	/**
	 *
	 * @var string
	 */
	protected static $_location_id;
	/**
	 *
	 * @var array
	 */
	protected static $_location;
	/**
	 *
	 * @return string encrypted location id
	 */
	protected static function getLocationId() {
		if (! static::$_location_id) {
			static::$_location_id = static::param ( Config::LOCATION_KEY );
		}
		return static::$_location_id;
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocationId($location_id) {
		static::$_location_id = $location_id;
		static::$_location = LocationMap::find ( static::$_location_id );
	}
	/**
	 *
	 * @return Location
	 */
	protected static function getLocation() {
		$location_id = static::getLocationId ();
		if (! static::$_location) {
			static::$_location = LocationMap::find ( $location_id );
		}
		return static::$_location ? static::$_location : LocationMap::earth ();
	}
}
