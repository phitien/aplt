<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;

trait  DeactivateTrait {
	/**
	 * Deactivate user
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function deactivate(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		$ok = $this->user ()->deactivate ();
		$this->doLogout ();
		return $this->jsonResponse ( 'deactivated_successfully', null );
	}
}
