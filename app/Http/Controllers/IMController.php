<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Response\Status as ResponseStatus;

class IMController extends Controller {
	/**
	 *
	 * @param unknown $message        	
	 * @param unknown $data        	
	 * @param unknown $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function json($message = null, $data = null, $status = ResponseStatus::OK, array $headers = [], $options = 0) {
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers, $options );
	}
}