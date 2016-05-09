<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Ezsell\Models\Location;

trait LocationTrait
{
	/**
	 *
	 * @var string
	 */
	protected static $_location_id;
	/**
	 *
	 * @var Location
	 */
	protected static $_location;
	/**
	 *
	 * @return string encrypted location id
	 */
	protected static function getLocationId() {
		if (! static::$_location_id) {
			static::$_location_id = request ()->header ( Config::LOCATION_KEY, Cookie::get ( Config::LOCATION_KEY, null ) );
		}
		return static::$_location_id;
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocationId($location_id) {
		static::$_location_id = $location_id;
		if (static::$_location_id && static::$_location_id > 0) {
			static::$_location = Location::find ( static::$_location_id );
		} else {
			static::$_location = null;
		}
	}
	/**
	 *
	 * @return Location
	 */
	protected static function getLocation() {
		$location_id = static::getLocationId ();
		if (! static::$_location && $location_id && $location_id > 0) {
			static::$_location = Location::find ( static::$_location_id );
		}
		return static::$_location;
	}
}
