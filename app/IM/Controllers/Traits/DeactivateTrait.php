<?php

namespace App\IM\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\IM\Utils;

trait  DeactivateTrait {
	/**
	 * Deactivate user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function deactivate(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		$ok = $this->_user->deactivate ();
		$this->doLogout ();
		return Utils::unsetResponseCookieToken ( $this->jsonResponse ( 'deactivated_successfully', null ) );
	}
}
