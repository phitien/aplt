<?php

namespace App\IM;

use App\IM\Response\Status;

class Utils {
	/**
	 *
	 * @return json response
	 *        
	 * @param unknown $message        	
	 * @param unknown $data        	
	 * @param unknown $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 */
	public static function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers, $options );
	}
	/**
	 *
	 * @return encrypted string
	 * @param string $str        	
	 */
	public static function encode(string $str) {
		return bcrypt ( $str );
	}
}
