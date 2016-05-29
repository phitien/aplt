<?php

namespace App\Platform\Traits;

use App\Platform\Config;
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
