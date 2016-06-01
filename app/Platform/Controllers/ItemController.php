<?php

namespace App\Platform\Controllers;

use Illuminate\Http\Request;
use App\Platform\Models\Item;
use App\Platform\Models\Image;
use Carbon\Carbon;
use App\Platform\Config;
use App\Platform\Controllers\Traits\ItemLikeTrait;
use App\Platform\Response\PageResponseData;
use App\Platform\Exceptions\ItemNotFound;

class ItemController extends Controller {
	use ItemLikeTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'details',
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
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function details(Request $request) {
		return $this->process ( 'details', func_get_args () );
	}
	protected function prepareItemDetailsPageResponseData(Request $request, $id) {
		$item = $this->getItemByIdOrCode ( $id );
		if ($item) {
			return $this->getPageResponseData ()->setType ( 'ItemDetails' )->setShowBanner ( false )->

			setData ( $item );
		}
		return false;
	}
	protected function pgetDetails(Request $request, $id) {
		if ($data = $this->prepareItemDetailsPageResponseData ( $request, $id )) {
			return $this->response ( view ( 'base', $data ) );
		} else {
			throw new ItemNotFound ();
		}
	}
	protected function pajaxgetDetails(Request $request, $id) {
		if ($data = $this->prepareItemDetailsPageResponseData ( $request, $id )) {
			return $this->jsonResponse ( 'item_details', $data );
		} else {
			throw new ItemNotFound ();
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
	protected function prepareSellItemPageResponseData(Request $request) {
		return $this->getPageResponseData ()->setType ( 'SellItemPage' )->setShowBanner ( false );
	}
	protected function pgetSellitem(Request $request) {
		return $this->response ( view ( 'base', $this->prepareSellItemPageResponseData ( $request ) ) );
	}
	protected function pajaxgetSellitem(Request $request) {
		$this->prepareSellItemPageResponseData ( $request );
		return $this->jsonResponse ( 'sellitem', $this->prepareSellItemPageResponseData ( $request ) );
	}
	protected function ppostSellitem(Request $request) {
		$this->createItem ( $request, $this->prepareSellItemPageResponseData ( $request ) );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function buyitem(Request $request) {
		return $this->process ( 'buyitem', func_get_args () );
	}
	protected function prepareBuyItemPageResponseData(Request $request) {
		return $this->getPageResponseData ()->setType ( 'BuyItemPage' )->setShowBanner ( false );
	}
	protected function pgetBuyitem(Request $request) {
		return $this->response ( view ( 'base', $this->prepareBuyItemPageResponseData ( $request ) ) );
	}
	protected function pajaxgetBuyitem(Request $request) {
		return $this->jsonResponse ( 'sellitem', $this->prepareBuyItemPageResponseData ( $request ) );
	}
	protected function ppostBuyitem(Request $request) {
		$this->createItem ( $request, $this->prepareBuyItemPageResponseData ( $request ) );
	}
	/**
	 *
	 * @param Request $request        	
	 * @param PageResponseData $responseData        	
	 */
	protected function createItem(Request $request, PageResponseData $pageResponseData) {
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
			$data->setAppMessage ( trans ( 'messages.errors.item_create_failed' ) );
			return $this->response ( view ( 'base', $data ) );
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
