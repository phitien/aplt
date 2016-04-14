<?php

namespace App\IM\Middleware;

use App\IM\Response\IResponse;
use Request;

interface IMiddleware extends IResponse {
	/**
	 *
	 * @param Request $request        	
	 * @param string $throwException        	
	 * @return App\User
	 */
	public function getUser($request, $throwException = false);
}
