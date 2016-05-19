<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Models\Item;
use App\Ezsell\Exceptions\ItemNotFound;
use App\Ezsell\Models\Cat;
use App\Ezsell\Models\Image;
use Carbon\Carbon;
use App\Ezsell\Config;
use App\Ezsell\Exceptions\UserNotFound;
use App\Ezsell\Controllers\Traits\ItemLikeTrait;

class ItemController extends Controller {
	use ItemLikeTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'index',
					'cat',
					'user',
					'item',
					'like' 
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
	public function index(Request $request) {
		return $this->response ( view ( 'home' ) );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function cat(Request $request) {
		return $this->process ( 'cat', func_get_args () );
	}
	/**
	 *
	 * @param Request $request        	
	 * @param unknown $query        	
	 * @return \Illuminate\Pagination\AbstractPaginator
	 */
	protected function addWhere(Request $request, $query) {
		$now = Carbon::now ();
		$requestTime = static::getRequestTime ();
		$query->where ( 'location_id', static::getLocationId () )->

		where ( 'items.is_selling', ( int ) static::getMode () )->

		where ( 'items.updated_at', '<=', $requestTime )->

		whereRaw ( "(items.deleted_at IS NULL OR items.deleted_at > '{$now}')" );
		return $query->paginate ( Config::PAGE_SIZE );
	}
	protected function pcatGetResponseData(Request $request, $id) {
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
			return [ 
					'catitems' => $cat,
					'paginate' => $paginate 
			];
		} else {
			return null;
		}
	}
	protected function pgetCat(Request $request, $id) {
		$data = $this->pcatGetResponseData ( $request, $id );
		if ($data) {
			return $this->response ( view ( 'item.catitems', [ 
					'data' => $data 
			] ) );
		} else {
			throw new ItemNotFound ();
		}
	}
	protected function pajaxCat(Request $request, $id) {
		$data = $this->pcatGetResponseData ( $request, $id );
		if ($data) {
			return $this->jsonResponse ( 'cat_item_list', $data );
		} else {
			throw new ItemNotFound ();
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function item(Request $request) {
		return $this->process ( 'item', func_get_args () );
	}
	protected function pgetItem(Request $request, $id) {
		$item = $this->getItemByIdOrCode ( $id );
		if ($item) {
			return $this->response ( view ( 'item.itemdetails', [ 
					'data' => [ 
							'itemdetails' => $item 
					] 
			] ) );
		} else {
			return $this->redirect ( Config::HOME_PAGE );
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function sellitem(Request $request) {
		return $this->process ( 'sellitem', func_get_args () );
	}
	protected function pgetSellitem(Request $request) {
		return $this->response ( view ( 'item.sellitem' ) );
	}
	protected function ppostSellitem(Request $request) {
		$this->createItem ( $request, 'item.sellitem' );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function buyitem(Request $request) {
		return $this->process ( 'buyitem', func_get_args () );
	}
	protected function pgetBuyitem(Request $request) {
		return $this->response ( view ( 'item.buyitem' ) );
	}
	protected function ppostBuyitem(Request $request) {
		$this->createItem ( $request, 'item.buyitem' );
	}
	protected function createItem(Request $request, $view) {
		$data = $request->only ( [ 
				'parent_id',
				'location_id',
				'title',
				'description',
				'is_selling',
				'is_new',
				'originalprice',
				'saleprice',
				'nowprice',
				'meetup_at',
				'meetup_details',
				'mailing_details',
				'groups',
				'deleted_at' 
		] );
		$data ['active'] = 1;
		$data ['is_new'] = $data ['is_new'] ? true : false;
		$data ['is_selling'] = $data ['is_selling'] ? true : false;
		$data ['user_id'] = static::getUser ()->id;
		$data ['location_id'] = static::getLocation ()->id;
		$data ['deleted_at'] = static::isDateInThePast ( $data ['deleted_at'] ) ? null : $data ['deleted_at'];
		if ($item = Item::create ( $data )) {
			$titles = $request->get ( 'files-title' );
			$descriptions = $request->get ( 'files-description' );
			foreach ( $request->file ( 'files' ) as $file ) {
				if ($file->isValid ()) {
					$name = $file->getClientOriginalName ();
					if (isset ( $titles [$name] )) {
						$url = $this->restful_upload ( $file );
						$image = new Image ( [ 
								'title' => $titles [$name],
								'description' => $descriptions [$name],
								'url' => $url 
						] );
						$image->item ()->associate ( $item );
						$image->save ();
					}
				}
			}
			if (Config::USE_CODE) {
				return $this->redirect ( "/item/{$item->code()}" );
			} else {
				return $this->redirect ( "/item/{$item->id}" );
			}
		} else {
			return $this->response ( view ( $view, [ 
					'appMessage' => trans ( 'messages.errors.item_create_failed' ) 
			] ) );
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function user(Request $request) {
		return $this->process ( 'user', func_get_args () );
	}
	protected function pgetUser(Request $request, $username) {
		$data = $this->puserGetResponseData ( $request, $username );
		if ($data) {
			return $this->response ( view ( 'item.useritems', [ 
					'data' => $data 
			] ) );
		} else {
			throw new UserNotFound ();
		}
	}
	protected function pajaxUser(Request $request, $username) {
		$data = $this->puserGetResponseData ( $request, $username );
		if ($data) {
			return $this->jsonResponse ( 'user_item_list', $data );
		} else {
			throw new UserNotFound ();
		}
	}
	protected function puserGetResponseData(Request $request, $username) {
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
					'useritems' => $user,
					'paginate' => $paginate 
			];
		} else {
			return null;
		}
	}
	
	/**
	 *
	 * @param string $id        	
	 * @return Item
	 */
	protected function getItemByIdOrCode($id) {
		if (Config::USE_CODE) {
			$id = static::decrypt ( $id );
		}
		return Item::find ( $id );
	}
}
