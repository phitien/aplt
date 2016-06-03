<?php

namespace App\Shared\Traits;

use Cookie;
use DateTime;
use App\Shared\Config;

trait UtilTrait {
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
		return request ()->get ( $key, request ()->header ( $key, Cookie::get ( $key, $default ) ) );
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
	 *
	 * @param unknown $header        	
	 * @return array cookies
	 */
	protected static function cookie_parse($header) {
		$cookies = array ();
		foreach ( $header as $line ) {
			if (preg_match ( '/^Set-Cookie: /i', $line )) {
				$line = preg_replace ( '/^Set-Cookie: /i', '', trim ( $line ) );
				$csplit = explode ( ';', $line );
				$cdata = array ();
				foreach ( $csplit as $data ) {
					$cinfo = explode ( '=', $data );
					$cinfo [0] = trim ( $cinfo [0] );
					if ($cinfo [0] == 'expires')
						$cinfo [1] = strtotime ( $cinfo [1] );
					if ($cinfo [0] == 'secure')
						$cinfo [1] = "true";
					if (in_array ( $cinfo [0], array (
							'domain',
							'expires',
							'path',
							'secure',
							'comment' 
					) )) {
						$cdata [trim ( $cinfo [0] )] = $cinfo [1];
					} else {
						$cdata ['value'] ['key'] = $cinfo [0];
						$cdata ['value'] ['value'] = $cinfo [1];
					}
				}
				$cookies [] = $cdata;
			}
		}
		return $cookies;
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
