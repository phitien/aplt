<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config;
use DateTime;

trait RequestTimeTrait {
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function getRequestTime() {
		return request ()->session ()->get ( Config::REQUEST_TIME, (new DateTime ())->format ( Config::DATETIME_DB_FORMAT ) );
	}
}
