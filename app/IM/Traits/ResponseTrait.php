<?php

namespace App\IM\Traits;

use App\IM\Config;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Cookie;

trait ResponseTrait
{
	/**
	 *
	 * @param BaseResponse $response        	
	 */
	protected static function addHeaders(BaseResponse $response) {
		$response = static::addCookieToResponse ( $response, Config::TOKEN_KEY, static::getToken () );
		return $response;
	}
	/**
	 *
	 * @param BaseResponse $response        	
	 */
	protected static function clearHeaders(BaseResponse $response) {
		$response = static::addCookieToResponse ( $response, Config::TOKEN_KEY, null );
		return $response;
	}
	/**
	 * Build response
	 *
	 * @param string $to        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param bool $secure        	
	 * @return BaseResponse
	 */
	public function redirect($to = Config::HOME_PAGE, $status = 302, $headers = [], $secure = null) {
		return static::addHeaders ( redirect ( $to, $status, $headers, $secure ) );
	}
	/**
	 *
	 * @param string $content        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($content, $status = Response::HTTP_OK, array $headers = []) {
		return static::addHeaders ( response ( $content, $status, $headers ) );
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
		return $this->addHeaders ( response ()->json ( [ 
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
	 * @param BaseResponse $response        	
	 * @param string $cookie        	
	 * @return BaseResponse
	 */
	public function setResponseToken(BaseResponse $response, $token) {
		return $response->withCookie ( Config::TOKEN_KEY, $token, true );
	}
}
