<?php

namespace App\Ezsell\Traits;

use Illuminate\Support\Facades\Crypt;

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
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encrypt($str) {
		return Crypt::encrypt ( $str );
	}
	
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function decrypt($str) {
		return Crypt::decrypt ( $str );
	}
}
