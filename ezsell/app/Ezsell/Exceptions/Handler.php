<?php

namespace App\Ezsell\Exceptions;

use App\Exceptions\Handler as BaseHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends BaseHandler {
	/**
	 * Render the given HttpException.
	 *
	 * @param \Symfony\Component\HttpKernel\Exception\HttpException $e        	
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function renderHttpException(HttpException $e) {
		$status = $e->getStatusCode ();
		if (view ()->exists ( "errors.{$status}" )) {
			$lines = explode ( "\n", $e->getTraceAsString () );
			return response ()->view ( "errors.{$status}", [ 
					'exception' => $e,
					'lines' => $lines 
			], $status, $e->getHeaders () );
		} else {
			return $this->convertExceptionToResponse ( $e );
		}
	}
}
