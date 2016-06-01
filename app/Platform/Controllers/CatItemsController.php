<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use App\Platform\Models\Item;
use App\Platform\Exceptions\ItemNotFound;
use App\Platform\Models\Cat;
use App\Platform\Config;
use App\Platform\Response\ListPageResponseData;
use App\Platform\Response\PageResponseData;

class CatItemsController extends ItemController {
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
	protected function prepareListPageResponseData(Request $request, $id) {
		if (Config::USE_CODE) {
			$cat = Cat::where ( 'code', strtoupper ( $id ) )->first ();
		} else {
			$cat = Cat::find ( $id );
		}
		if ($cat) {
			$paginate = $this->addWhere ( $request, $cat->items () );
			$items = $paginate->getCollection ();
			$user_ids = [ ];
			foreach ( $items as $item ) {
				array_push ( $user_ids, $item->user_id );
			}
			$response = $this->apiCallInfo ( [ 
					'ids' => implode ( ',', array_unique ( $user_ids ) ) 
			] );
			
			$users = static::json_decode ( $response->getBody (), true ) ['data'];
			for($i = 0; $i < count ( $items ); $i ++) {
				if (isset ( $users [$items [$i]->user_id] ))
					$items [$i] ['user'] = $users [$items [$i]->user_id];
				else
					$items [$i] ['user'] = [ ];
			}
			
			return $this->setPageResponseData ( new ListPageResponseData ( 'CatItems' ) )->setShowBanner ( false )->

			setData ( $cat )->setPaginate ( $paginate );
		}
		return false;
	}
	protected function pgetList(Request $request, $id) {
		if ($data = $this->prepareListPageResponseData ( $request, $id )) {
			return $this->response ( view ( 'base', $data ) );
		} else {
			throw new ItemNotFound ();
		}
	}
	protected function pajaxgetList(Request $request, $id) {
		if ($data = $this->prepareListPageResponseData ( $request, $id )) {
			return $this->jsonResponse ( 'cat_item_list', $data );
		} else {
			throw new ItemNotFound ();
		}
	}
}
