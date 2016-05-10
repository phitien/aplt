<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Ezsell\Config\LocationMap;

trait LocationTrait
{
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
			// static::$_location_id = request ()->header ( Config::LOCATION_KEY, Cookie::get ( Config::LOCATION_KEY, null ) );
			static::$_location_id = request ()->get ( Config::LOCATION_KEY, request ()->header ( Config::LOCATION_KEY, Cookie::get ( Config::LOCATION_KEY, null ) ) );
		}
		return static::$_location_id;
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocationId($location_id) {
		static::$_location_id = $location_id;
		static::$_location = LocationMap::get ( static::$_location_id );
	}
	/**
	 *
	 * @return Location
	 */
	protected static function getLocation() {
		$location_id = static::getLocationId ();
		if (! static::$_location) {
			static::$_location = LocationMap::get ( $location_id );
		}
		return static::$_location;
	}
}
