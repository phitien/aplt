<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Ezsell\Models\Location;
use Exception;

trait LocationTrait
{
	/**
	 *
	 * @var string
	 */
	protected static $_location;
	/**
	 *
	 * @return string encrypted location id
	 */
	protected static function getLocation() {
		if (! static::$_location) {
			static::$_location = request ()->header ( Config::LOCATION_KEY, Cookie::get ( Config::LOCATION_KEY, null ) );
		}
		try {
			return static::$_location ? Location::find ( static::$_location ) : null;
		} catch ( Exception $e ) {
			return null;
		}
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocation($location) {
		static::$_location = $location;
	}
}
