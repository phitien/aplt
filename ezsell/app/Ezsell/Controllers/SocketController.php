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
		return $this->process ( 'sendmessage', func_get_args () );
	}
	protected function pajaxSendmessage(Request $request) {
		$message = $request->get ( 'message' );
		$redis = LRedis::connection ();
		$to = ( int ) $request->get ( 'code' );
		$from = static::getUser ();
		if ($to && $from) {
			$domain = $request->server->get ( 'SERVER_NAME' );
			$data = [ 
					'to' => "{$to}+{$domain}",
					'from' => "{$from->id}+{$domain}",
					'message' => $message,
					'user' => $from 
			];
			$redis->publish ( 'message', json_encode ( $data ) );
			return $this->jsonResponse ( 'sent' );
		}
		return $this->jsonResponse ( 'no_user_found' );
	}
}
