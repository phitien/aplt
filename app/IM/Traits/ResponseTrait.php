<?php

namespace App\IM\Traits;

use App\IM\Config;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Cookie;

trait ResponseTrait
{
	/**
	 *
	 * @param \Illuminate\Http\Response $response        	
	 */
	protected static function applyCookies($response) {
		return $response-> //

		withCookie ( Cookie::forever ( Config::TOKEN_KEY, static::getToken () ), true );
	}
	/**
	 *
	 * @param \Illuminate\Http\Response $response        	
	 */
	protected static function clearCookies($response) {
		return $response-> //

		withCookie ( Config::TOKEN_KEY, null, true );
	}
	/**
	 * Build response
	 *
	 * @param string $to        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param bool $secure        	
	 * @return \Illuminate\Http\Response
	 */
	public function redirect($to = Config::HOME_PAGE, $status = 302, $headers = [], $secure = null) {
		return static::applyCookies ( redirect ( $to, $status, $headers, $secure ) );
	}
	/**
	 *
	 * @param string $content        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($content, $status = Response::HTTP_OK, array $headers = []) {
		return static::applyCookies ( response ( $content, $status, $headers ) );
	}
	/**
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jsonResponse($message = null, $data = null, $status = Response::HTTP_OK, array $headers = []) {
		return $this->applyCookies ( response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers ) );
	}
	/**
	 *
	 * @param Response $response        	
	 * @param string $message        	
	 * @param string $data        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateJsonResponse(JsonResponse $response, $message = null, $data = null) {
		return $response->setData ( [ 
				'message' => $message,
				'data' => $data 
		] );
	}
	/**
	 * set the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Response $response        	
	 * @param string $cookie        	
	 * @return \Illuminate\Http\Response
	 */
	public function setResponseToken($response, $token) {
		return $response->withCookie ( Config::TOKEN_KEY, $token, true );
	}
}
