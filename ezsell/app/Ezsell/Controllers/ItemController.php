<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Models\Item;
use App\Ezsell\Exceptions\ItemNotFound;
use App\Ezsell\Models\Cat;
use App\Ezsell\Models\Image;
use Carbon\Carbon;

class ItemController extends Controller {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'index',
					'cat',
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
		$cat = Cat::find ( $id );
		if ($cat) {
			$now = Carbon::now ();
			return $this->response ( view ( 'item.items', [ 
					'cat' => $cat,
					'items' => $cat->items ()->

					where ( 'location_id', static::getLocationId () )->

					whereRaw ( "(items.deleted_at IS NULL OR items.deleted_at > '{$now}')" )->

					get () 
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
		$item = Item::find ( $id );
		if ($item) {
			return $this->response ( view ( 'item.detail', [ 
					'item' => $item 
			] ) );
		} else {
			return $this->redirect ( '/' );
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
				'groups' 
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
			return $this->redirect ( "/item/{$item->id}" );
		} else {
			return $this->response ( view ( $view, [ 
					'appMessage' => 'Không hiểu sao ko tạo được :(, sorry nha' 
			] ) );
		}
	}
}
