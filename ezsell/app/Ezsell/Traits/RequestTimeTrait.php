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
		if (! \App\Ezsell\Helper::$_request_time) {
			\App\Ezsell\Helper::$_request_time = (new DateTime ())->format ( Config::DATETIME_DB_FORMAT );
		}
		return \App\Ezsell\Helper::$_request_time;
	}
	protected static function setRequestTime($datetime) {
		\App\Ezsell\Helper::$_request_time = DateTime::createFromFormat ( Config::DATETIME_DB_FORMAT, $datetime )->format ( Config::DATETIME_DB_FORMAT );
	}
}
