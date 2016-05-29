<?php

namespace App\Platform;

use App\Shared\Config as SharedConfig;

class Config extends SharedConfig {
	public static $modes = [ 
			'SELL' => 1,
			'BUY' => 0 
	];
	const PAGE_SIZE = 18;
	const USE_CODE = true;
	const HOME_PAGE = '/';
	const LOCATION_KEY = 'location';
	const REQUEST_TIME = 'requesttime';
	const MODE = 'mode';
}