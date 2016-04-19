<?php

namespace App\IM\Traits;

trait EncoderTrait
{
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encode($str) {
		return bcrypt ( $str );
	}
}
