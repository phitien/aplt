<?php

namespace App\Ezsell\Middleware;

use App\Http\Middleware\VerifyCsrfToken as BaseVerifyCsrfToken;

class VerifyCsrfToken extends BaseVerifyCsrfToken {
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [ ];
}
