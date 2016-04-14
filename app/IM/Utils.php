<?php

namespace App\IM;

use App\IM\Response\Status;

class Utils {
	/**
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return Response
	 */
	public static function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers, $options );
	}
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encode(string $str) {
		return bcrypt ( $str );
	}
}
