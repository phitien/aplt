<?php

namespace App\Platform\Controllers;

use App\Platform\Response\IResponse;

interface IController extends IResponse {
	/**
	 *
	 * @return array
	 */
	public function getMiddlewareOptions($middleware);
}