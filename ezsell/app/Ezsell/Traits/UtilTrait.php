<?php

namespace App\Ezsell\Traits;

use Illuminate\Support\Facades\Crypt;

trait UtilTrait {
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
	/**
	 *
	 * @return string
	 */
	protected static function getBaseUri() {
		return (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' );
	}
	/**
	 *
	 * @return string
	 */
	protected static function getRedirectUri() {
		return request ()->get ( 'redirect', '/' );
	}
}
