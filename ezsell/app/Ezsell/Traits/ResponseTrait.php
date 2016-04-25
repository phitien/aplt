<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
	/**
	 * Build response
	 *
	 * @param string $to        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param bool $secure        	
	 * @return \Illuminate\Http\Response
	 */
	public function redirect($to = null, $status = 302, $headers = [], $secure = null) {
		if (! $to)
			$to = Config::HOME_PAGE;
		return redirect ( $to, $status, $headers, $secure )->withCookie ( Config::TOKEN_KEY, static::getToken (), true )->withCookie ( Config::EZSELL_KEY, static::encrypt ( ( string ) static::getUser () ), true );
	}
	/**
	 *
	 * @param string $content        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($content, $status = Response::HTTP_OK, array $headers = []) {
		return response ( $content, $status, $headers )->withCookie ( Config::TOKEN_KEY, static::getToken (), true )->withCookie ( Config::EZSELL_KEY, static::encrypt ( ( string ) static::getUser () ), true );
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
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers )->withCookie ( Config::TOKEN_KEY, static::getToken (), true )->withCookie ( Config::EZSELL_KEY, static::encrypt ( ( string ) static::getUser () ), true );
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
