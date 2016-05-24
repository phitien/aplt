<?php

namespace App\Platform\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Platform\Traits\AllTrait;
use App\Platform\Models\Item;
use App\Platform\Models\Like;

trait ItemLikeTrait {
	use AllTrait;
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function like(Request $request) {
		return $this->process ( 'like', func_get_args () );
	}
	protected function pajaxLike(Request $request) {
		$id = $request->get ( 'id' );
		$item = $this->getItemByIdOrCode ( $id );
		if ($item) {
			$user_id = $request->get ( 'user_id' );
			if ($user_id && ( int ) $user_id == $user_id) {
				$like = $item->likes ()->where ( 'user_id', $user_id )->first ();
				if ($like) {
					$like->delete ();
					return $this->jsonResponse ( 'unliked', $item );
				} else {
					$like = new Like ( [ 
							'user_id' => $user_id 
					] );
					$like->item ()->associate ( $item );
					$like->save ();
					return $this->jsonResponse ( 'liked', $item );
				}
			} else {
				return $this->jsonResponse ( trans ( 'messages.errors.user_not_found' ), null, Response::HTTP_BAD_REQUEST );
			}
		} else {
			return $this->jsonResponse ( trans ( 'messages.errors.item_not_found' ), null, Response::HTTP_BAD_REQUEST );
		}
	}
}
