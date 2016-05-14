<?php

namespace App\IM\Controllers;

use App\IM\Response\IResponse;

interface IController extends IResponse {
	/**
	 *
	 * @return array
	 */
	public function getMiddlewareOptions($middleware);
}