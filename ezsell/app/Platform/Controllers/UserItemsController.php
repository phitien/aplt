<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use App\Platform\Models\Item;
use Carbon\Carbon;
use App\Platform\Exceptions\UserNotFound;
use App\Platform\Controllers\Traits\ItemLikeTrait;

class UserItemsController extends Controller {
	use ItemLikeTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'list' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ ] 
	];
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function list(Request $request) {
		return $this->process ( 'list', func_get_args () );
	}
	protected function pgetList(Request $request, $username) {
		$data = $this->getResponseData ( $request, $username );
		if ($data) {
			return $this->response ( view ( 'item.useritems', $data ) );
		} else {
			throw new UserNotFound ();
		}
	}
	protected function pajaxList(Request $request, $username) {
		$data = $this->getResponseData ( $request, $username );
		if ($data) {
			return $this->jsonResponse ( 'user_item_list', $data );
		} else {
			throw new UserNotFound ();
		}
	}
	protected function getResponseData(Request $request, $username) {
		$response = $this->apiCallInfo ( [ 
				'code' => $username 
		] );
		$user = static::json_decode ( $response->getBody (), true ) ['data'];
		if ($user) {
			$now = Carbon::now ();
			
			$requestTime = static::getRequestTime ();
			$paginate = $this->addWhere ( $request, Item::where ( 'user_id', $user ['id'] ) );
			
			$items = $paginate->getCollection ();
			for($i = 0; $i < count ( $items ); $i ++) {
				$items [$i] ['user'] = $user;
			}
			return [ 
					'type' => 'UserItemsPage',
					'data' => $user,
					'paginate' => $paginate 
			];
		} else {
			return null;
		}
	}
}
