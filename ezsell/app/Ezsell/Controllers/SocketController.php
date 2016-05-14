<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use LRedis;

class SocketController extends Controller {
	/**
	 *
	 * @var array $_locationMiddlewareOptions
	 */
	protected $_locationMiddlewareOptions = [ 
			'except' => [ 
					'sendmessage' 
			] 
	];
	public function sendmessage(Request $request) {
		$message = $request->get ( 'message' );
		$redis = LRedis::connection ();
		$redis->publish ( 'message', $message );
		return $this->jsonResponse ( 'sent', $message );
	}
}
