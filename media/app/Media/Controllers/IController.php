<?php

namespace App\Media\Controllers;

use App\Media\Response\IResponse;

interface IController extends IResponse {
	/**
	 *
	 * @return array
	 */
	public function getAuthenticationMiddlewareOptions();
	/**
	 *
	 * @return array
	 */
	public function getAuthorizationMiddlewareOptions();
}