<?php

namespace App\IM\Middleware;

use App\IM\Response\IResponse;
use Request;

interface IMiddleware extends IResponse {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT);
	/**
	 *
	 * @param Request $request        	
	 * @param string $throwException        	
	 * @return App\User
	 */
	public function getUser($request, $throwException = false);
}
