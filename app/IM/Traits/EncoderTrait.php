<?php

namespace App\IM\Traits;

trait EncoderTrait
{
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected function encode(string $str) {
		return bcrypt ( $str );
	}
}
