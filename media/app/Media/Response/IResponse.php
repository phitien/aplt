<?php

namespace App\Media\Response;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

interface IResponse {
	/**
	 * Build response
	 *
	 * @param string $to        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param bool $secure        	
	 * @return \Illuminate\Http\Response
	 */
	public function redirect($to = null, $status = 302, $headers = [], $secure = null);
	/**
	 * Build response
	 *
	 * @param string $content        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($content, $status = Response::HTTP_OK, array $headers = []);
	/**
	 * Build json response
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jsonResponse($message = null, $data = null, $status = Response::HTTP_OK, array $headers = []);
	/**
	 *
	 * @param Response $response        	
	 * @param string $message        	
	 * @param string $data        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateJsonResponse(JsonResponse $response, $message = null, $data = null);
	/**
	 * set the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Response $response        	
	 * @param string $cookie        	
	 * @return \Illuminate\Http\Response
	 */
	public function setResponseToken($response, $cookie);
	/**
	 *
	 * @param string $path        	
	 */
	public function pumpImagePath($path = '');
	/**
	 *
	 * @param Image $image        	
	 */
	public function pumpImage($image);
	/**
	 */
	public function pumpNoImage();
	/**
	 */
	public function pumpUnauthenticated();
	/**
	 */
	public function pumpUnauthorized();
}