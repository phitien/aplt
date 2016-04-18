<?php

namespace App\IM\Response;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

interface IResponse {
	/**
	 * Build response
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($status = Response::HTTP_OK, array $headers = []);
	/**
	 * Build json response
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function jsonResponse($message = null, $data = null, $status = Response::HTTP_OK, array $headers = []);
	/**
	 *
	 * @param Response $response        	
	 * @param string $message        	
	 * @param string $data        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function updateJsonResponse(JsonResponse $response, $message = null, $data = null);
}