<?php

namespace App\Shared\Traits;

use Cookie;
use DateTime;
use App\Shared\Config;

trait UtilTrait {
	use TokenTrait;
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected static function encode($str) {
		return bcrypt ( $str );
	}
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected static function encrypt($string) {
		$data = base64_encode ( $string );
		$data = str_replace ( array (
				'+',
				'/',
				'=' 
		), array (
				'-',
				'_',
				'' 
		), $data );
		return $data;
	}
	
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected static function decrypt($string) {
		$data = str_replace ( array (
				'-',
				'_' 
		), array (
				'+',
				'/' 
		), $string );
		$mod4 = strlen ( $data ) % 4;
		if ($mod4) {
			$data .= substr ( '====', $mod4 );
		}
		return base64_decode ( $data );
	}
	/**
	 *
	 * @param string $str        	
	 */
	protected static function json_decode($json, $assoc = null, $depth = null, $options = null) {
		$json = preg_replace ( '/[\pZ\pC]+|[\pZ\pC]+/u', '', $json );
		return json_decode ( $json, $assoc, $depth, $options );
	}
	/**
	 *
	 * @param unknown $key        	
	 * @param unknown $default        	
	 */
	protected static function param($key, $default = null) {
		return request ()->session ()->get ( $key, request ()->header ( $key, request ()->get ( $key, $default ) ) );
	}
	/**
	 *
	 * @param string $datetime        	
	 */
	protected static function isDateInThePast($datetime) {
		return DateTime::createFromFormat ( Config::DATETIME_DB_FORMAT, $datetime ) < (new DateTime ());
	}
	/**
	 *
	 * @return string base uri
	 */
	protected static function getBaseUri() {
		return (request ()->secure () ? 'https://' : 'http://') . strtolower ( request ()->server ( 'SERVER_NAME' ) );
	}
	/**
	 * Add cookie
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected static function addCookieToResponse($response, $key, $value) {
		$config = config ( 'session' );
		$response->headers->setCookie ( new \Symfony\Component\HttpFoundation\Cookie ( $key, $value, time () + 60 * 120, $config ['path'], $config ['domain'], $config ['secure'], false ) );
		return $response;
	}
}
