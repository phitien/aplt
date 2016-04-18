<?php

namespace App\IM\Traits;

use App\IM\Config\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
	/**
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($status = Response::HTTP_OK, array $headers = []) {
		return $this->setResponseCookieToken ( response ( '', $status, $headers ), $this->token () );
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
		return $this->setResponseCookieToken ( response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers ), $this->token () );
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
	public function setResponseCookieToken($response, $cookie) {
		$expiringTime = time () + Config::TOKEN_EXPIRING_TIME;
		return $response->withCookie ( Config::TOKEN_KEY, $cookie, $expiringTime );
	}
	/**
	 * unset the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Response $response        	
	 * @param string $cookie        	
	 * @return \Illuminate\Http\Response
	 */
	public function forgetResponseCookieToken($response) {
		return $response->withCookie ( Config::TOKEN_KEY, Cookie::forget ( Config::TOKEN_KEY ) );
	}
	/**
	 *
	 * @return string
	 */
	protected function getRequestBaseUrl() {
		return (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' );
	}
}
