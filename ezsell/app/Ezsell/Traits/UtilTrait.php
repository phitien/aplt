<?php

namespace App\Ezsell\Traits;

trait UtilTrait {
	/**
	 *
	 * @return string
	 */
	protected static function getBaseUri() {
		return (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' );
	}
	/**
	 *
	 * @return string
	 */
	protected static function getRedirectUri() {
		return request ()->get ( 'redirect', '/' );
	}
}
