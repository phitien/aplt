<?php

namespace App\IM\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\IM\Response\Status;

class TokenNotFound extends JWTException {
	/**
	 *
	 * @var int
	 */
	protected $statusCode = Status::BadRequest;
}
