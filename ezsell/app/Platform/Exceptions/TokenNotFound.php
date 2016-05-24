<?php

namespace App\Platform\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response;

class TokenNotFound extends JWTException {
	/**
	 *
	 * @var int
	 */
	protected $statusCode = Response::HTTP_BAD_REQUEST;
	/**
	 *
	 * @var string
	 */
	protected $message = 'token_not_found';
}
