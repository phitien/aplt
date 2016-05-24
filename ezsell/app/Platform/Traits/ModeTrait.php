<?php

namespace App\Platform\Traits;

use App\Platform\Config;

trait ModeTrait {
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function getMode() {
		if (! \App\Platform\Helper::$_mode) {
			\App\Platform\Helper::$_mode = static::param ( 'mode', Config::$modes ['SELL'] );
		}
		return \App\Platform\Helper::$_mode;
	}
	protected static function setMode($mode) {
		\App\Platform\Helper::$_mode = ( int ) $mode > 0 ? Config::$modes ['SELL'] : Config::$modes ['BUY'];
	}
}
