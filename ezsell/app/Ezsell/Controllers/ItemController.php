<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Models\Item;
use App\Ezsell\Exceptions\ItemNotFound;
use App\Ezsell\Models\Cat;
use App\Ezsell\Models\Image;
use Carbon\Carbon;
use App\Ezsell\Config;

class ItemController extends Controller {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'index',
					'cat',
					'user',
					'item' 
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
	protected function pgetCat(Request $request, $id) {
		if (Config::USE_CODE) {
			$cat = Cat::where ( 'code', strtoupper ( $id ) )->first ();
		} else {
			$cat = Cat::find ( $id );
		}
		if ($cat) {
			$now = Carbon::now ();
			$query = $cat->items ()->where ( 'location_id', static::getLocationId () )->

			whereRaw ( "(items.deleted_at IS NULL OR items.deleted_at > '{$now}')" );
			
			$pagination = $query->paginate ( Config::PAGE_SIZE );
			$items = $pagination->getCollection ();
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
			return $this->response ( view ( 'item.catitems', [ 
					'catitems_cat' => $cat,
					'catitems_items' => $items 
			] ) );
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
		if (Config::USE_CODE) {
			$id = static::decrypt ( $id );
		}
		$item = Item::find ( $id );
		if ($item) {
			return $this->response ( view ( 'item.itemdetails', [ 
					'itemdetails_item' => $item 
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
		$data ['is_new'] = $data ['is_new'] ? true : false;
		$data ['is_selling'] = $data ['is_selling'] ? true : false;
		$data ['user_id'] = static::getUser ()->id;
		$data ['location_id'] = static::getLocation ()->id;
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
				return $this->redirect ( "/cat/{$item->code()}" );
			} else {
				return $this->redirect ( "/item/{$item->id}" );
			}
		} else {
			return $this->response ( view ( $view, [ 
					'appMessage' => 'Không hiểu sao ko tạo được :(, sorry nha' 
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
		$response = $this->apiCallInfo ( [ 
				'code' => $username 
		] );
		$user = static::json_decode ( $response->getBody (), true ) ['data'];
		if ($user) {
			$pagination = Item::where ( 'user_id', $user ['id'] )->paginate ( Config::PAGE_SIZE );
			$items = $pagination->getCollection ();
			for($i = 0; $i < count ( $items ); $i ++) {
				$items [$i] ['user'] = $user;
			}
			return $this->response ( view ( 'item.useritems', [ 
					'useritems_user' => json_encode ( $user ),
					'useritems_items' => $items 
			] ) );
		} else {
			return $this->redirect ( Config::HOME_PAGE );
		}
	}
}
