<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use LRedis;
use App\Platform\Models\Message;
use App\Platform\Models\Item;
use App\Platform\Config;
use DB;

class SocketController extends Controller {
	/**
	 *
	 * @var array $_locationMiddlewareOptions
	 */
	protected $_locationMiddlewareOptions = [ 
			'except' => [ 
					'sendmessage',
					'messages' 
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
	public function messages(Request $request) {
		return $this->process ( 'messages', func_get_args () );
	}
	protected function pajaxMessages(Request $request) {
		$to = ( int ) $request->get ( 'code' );
		$response = static::apiCallInfo ( [ 
				'ids' => $to,
				'first' => true 
		] );
		$touser = static::json_decode ( $response->getBody (), true ) ['data'];
		if ($to && $touser) {
			$from = static::getUser ();
			if ($from && ! $from->isGuest ()) {
				$messages = [ ];
				$paginate = Message::where ( 'from_id', '=', $from->id )->where ( 'to_id', '=', $touser ['id'] )->

				orWhere ( function ($query) use ($from, $touser) {
					$query->where ( 'from_id', '=', $touser ['id'] )->where ( 'to_id', '=', $from->id );
				} )->paginate ( Config::PAGE_SIZE );
				
				$items = $paginate->getCollection ();
				
				foreach ( $items as $item ) {
					array_push ( $messages, $item->from_id == $from->id ? [ 
							'receiver' => $from,
							'message' => $item->content,
							'created_at' => $item->created_at,
							'status' => $item->status 
					] : [ 
							'sender' => $touser,
							'message' => $item->content,
							'created_at' => $item->created_at,
							'status' => $item->status 
					] );
				}
				return $this->jsonResponse ( 'list_messages', [ 
						'messages' => $messages,
						'paginate' => $paginate 
				] );
			}
			return $this->jsonResponse ( 'no_user_found' );
		}
		return $this->jsonResponse ( 'no_receiver_found' );
	}
}
