<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\IM\Traits\AllTrait;
use App\IM\Models\Info;

trait  InfoTrait {
	use AllTrait;
	/**
	 * Return a JWT
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function info(Request $request) {
		return $this->process ( 'info', func_get_args () );
	}
	protected function ppostInfo(Request $request) {
		$ids = $request->input ( 'ids' );
		if ($ids) {
			if (is_string ( $ids )) {
				$ids = explode ( ',', $ids );
				if ($ids) {
					$users = Info::whereIn ( 'id', $ids )->get ();
					$info = [ ];
					foreach ( $users as $user ) {
						$info [$user->id] = $user;
					}
					return $this->jsonResponse ( 'users_info', $info );
				}
			}
		} else {
			$code = $request->input ( 'code' );
			if ($code) {
				$info = Info::where ( 'name', $code )->first ();
				if ($info) {
					return $this->jsonResponse ( 'user_info', $info );
				}
			}
		}
		return $this->jsonResponse ( 'no_user_found' );
	}
}
