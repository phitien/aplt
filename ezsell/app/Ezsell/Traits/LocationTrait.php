<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Ezsell\Models\Place;

trait LocationTrait
{
	/**
	 *
	 * @var string
	 */
	protected static $_location;
	/**
	 *
	 * @return string encrypted place id
	 */
	protected static function getLocation() {
		if (! static::$_location) {
			static::$_location = request ()->header ( Config::LOCATION_KEY, Cookie::get ( Config::LOCATION_KEY, null ) );
		}
		return static::$_location;
	}
	/**
	 *
	 * @param int $place_id        	
	 */
	protected static function setLocation($location) {
		static::$_location = static::encrypt ( $location );
	}
	/**
	 *
	 * @return Place $place
	 */
	protected static function getPlace() {
		$place = Place::find ( static::decrypt ( static::$_location ) );
		return $place ? $place : Place::getCountry ( 'SG' );
	}
}
