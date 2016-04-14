<?php

namespace App\IM\Middleware;

use App\IM\Response\IResponse;

interface IMiddleware extends IResponse {
	public function getUser($request, $throwException = false);
}
