<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use App\Platform\Models\Item;
use Carbon\Carbon;
use App\Shared\Exceptions\UserNotFound;
use App\Platform\Controllers\Traits\ItemLikeTrait;
use App\Platform\Response\ListPageResponseData;
use App\Platform\Response\PageResponseData;

class UserItemsController extends ItemController {
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
	/**
	 *
	 * @return PageResponseData
	 */
	protected function prepareListPageResponseData(Request $request, $username) {
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
			
			return $this->setPageResponseData ( new ListPageResponseData ( 'UserItems' ) )->setShowBanner ( false )->

			setData ( $user )->setPaginate ( $paginate );
		}
		return false;
	}
	protected function pgetList(Request $request, $username) {
		if ($data = $this->prepareListPageResponseData ( $request, $username )) {
			return $this->response ( view ( 'base', $data ) );
		} else {
			throw new UserNotFound ();
		}
	}
	protected function pajaxpostList(Request $request, $username) {
		if ($data = $this->prepareListPageResponseData ( $request, $username )) {
			return $this->jsonResponse ( 'user_item_list', $data );
		} else {
			throw new UserNotFound ();
		}
	}
}
