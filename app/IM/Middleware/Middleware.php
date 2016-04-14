<?php

namespace App\IM\Middleware;

use App\IM\Utils;
use App\IM\Response\Status;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Closure;
use App\IM\Config;

abstract class Middleware extends BaseMiddleware implements IMiddleware {
	public function handle($request, Closure $next, $action = Config::ACTION_DEFAULT) {
		return $next ( $request );
	}
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \App\IM\Response\IResponse::jsonResponse()
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
	}
}
