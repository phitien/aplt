<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Response\Status as ResponseStatus;

class IMController extends Controller {
	protected function json($message = null, $data = null, $status = ResponseStatus::OK, array $headers = [], $options = 0) {
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers, $options );
	}
}