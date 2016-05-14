<?php

namespace App\Media\Traits;

use Illuminate\Http\Request;
use Cookie;
use App\Media\Traits\UtilTrait;

trait RequestTrait
{
	use UtilTrait;
	/**
	 *
	 * @param unknown $key        	
	 * @param unknown $default        	
	 */
	protected static function param($key, $default = null) {
		return request ()->get ( $key, request ()->header ( $key, Cookie::get ( $key, null ) ) );
	}
}
