<?php

namespace App\Media\Response;

use Illuminate\Http\Response;
use App\Shared\Response\IResponse as ISharedResponse;

interface IResponse extends ISharedResponse {
	/**
	 *
	 * @param string $path        	
	 */
	public function pumpImagePath($path = '');
	/**
	 *
	 * @param Image $image        	
	 */
	public function pumpImage($image);
	/**
	 */
	public function pumpNoImage();
	/**
	 */
	public function pumpUnauthenticated();
	/**
	 */
	public function pumpUnauthorized();
}