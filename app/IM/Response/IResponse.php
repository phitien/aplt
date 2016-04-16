<?php

namespace App\IM\Response;

use Illuminate\Http\Response;

interface IResponse {
	/**
	 * Build response
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return Response
	 */
	public function response($status = Status::OK, array $headers = []);
	/**
	 * Build json response
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return Response
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0);
}