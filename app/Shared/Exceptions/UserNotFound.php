<?php

namespace App\Shared\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response;

class UserNotFound extends JWTException {
	/**
	 *
	 * @var int
	 */
	protected $statusCode = Response::HTTP_BAD_REQUEST;
	/**
	 *
	 * @var string
	 */
	protected $message = 'user_not_found';
}
