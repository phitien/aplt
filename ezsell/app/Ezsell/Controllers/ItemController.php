<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Models\Item;
use App\Ezsell\Exceptions\ItemNotFound;
use App\Ezsell\Models\Cat;

class ItemController extends BaseController {
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
	protected function getCat(Request $request, $id) {
		$cat = Cat::find ( $id );
		if ($cat) {
			return $this->response ( view ( 'item.items', [ 
					'cat' => $cat,
					'items' => $cat->items ()->get () 
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
	public function newitem(Request $request) {
		return $this->process ( 'newitem', func_get_args () );
	}
	protected function getNewitem(Request $request) {
		return $this->response ( view ( 'item.newitem' ) );
	}
	protected function postNewitem(Request $request) {
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
		$data ['user_id'] = static::getUser ()->id;
		$data ['location_id'] = static::getLocation ()->id;
		$item = Item::create ( $data );
		return $this->redirect ( "/item/{$item->id}" );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function item(Request $request) {
		return $this->process ( 'item', func_get_args () );
	}
	protected function getItem(Request $request, $id) {
		$item = Item::find ( $id );
		if ($item) {
			return $this->response ( view ( 'item.detail', [ 
					'item' => $item 
			] ) );
		} else {
			throw new ItemNotFound ();
		}
	}
}
