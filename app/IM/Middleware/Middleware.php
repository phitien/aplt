<?php

namespace App\IM\Middleware;

use App\IM\Utils;
use App\IM\Response\Status;

abstract class Middleware implements IMiddleware {
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
