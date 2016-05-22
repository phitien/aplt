<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use LRedis;
use App\Ezsell\Models\Message;
use App\Ezsell\Models\Item;
use function GuzzleHttp\json_decode;
use function Predis\object;

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
		$msg = $request->get ( 'message' );
		if ($msg) {
			$to = ( int ) $request->get ( 'code' );
			$response = static::apiCallInfo ( [ 
					'ids' => $to,
					'first' => true 
			] );
			$touser = static::json_decode ( $response->getBody (), true ) ['data'];
			if ($to && $touser) {
				$from = static::getUser ();
				if ($from && ! $from->isGuest ()) {
					$message = new Message ( [ 
							'to_id' => $to,
							'from_id' => $from->id,
							'content' => $msg 
					] );
					$item_id = $request->get ( 'id' );
					if ($item_id && $item = Item::find ( $item_id )) {
						$message->item ()->associate ( $item );
					}
					$message->save ();
					$domain = $request->server->get ( 'SERVER_NAME' );
					$redis = LRedis::connection ();
					$redis->publish ( 'message', json_encode ( [ 
							'to' => "{$to}+{$domain}",
							'message' => $msg,
							'sender' => $from,
							'created_at' => $message->created_at,
							'status' => $message->status 
					] ) );
					return $this->jsonResponse ( 'sent', [ 
							'receiver' => $touser,
							'message' => $msg,
							'created_at' => $message->created_at,
							'status' => $message->status 
					] );
				}
				return $this->jsonResponse ( 'no_user_found' );
			}
			return $this->jsonResponse ( 'no_receiver_found' );
		}
		return $this->jsonResponse ( 'message_empty' );
	}
}
