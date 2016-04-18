<?php

namespace App\Ezsell\Controllers;

use App\Ezsell\Response\IResponse;

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