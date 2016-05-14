<?php

namespace App\Media\Controllers;

use App\Media\Response\IResponse;

interface IController extends IResponse {
	/**
	 *
	 * @return array
	 */
	public function getMiddlewareOptions($middleware);
}