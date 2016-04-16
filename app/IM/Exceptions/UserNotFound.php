<?php

namespace App\IM\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\IM\Response\Status;

class UserNotFound extends JWTException {
	/**
	 *
	 * @var int
	 */
	protected $statusCode = Status::BadRequest;
	/**
	 *
	 * @var string
	 */
	protected $message = 'user_not_found';
}
