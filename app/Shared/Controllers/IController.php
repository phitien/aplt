<?php

namespace App\Shared\Controllers;

use App\Shared\Response\IResponse;

interface IController extends IResponse {
	/**
	 *
	 * @return array
	 */
	public function getMiddlewareOptions($middleware);
}