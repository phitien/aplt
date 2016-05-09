<?php

namespace App\IM\Traits;

use App\IM\Config\Config;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

trait ResponseTrait
{
	/**
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($content = '', $status = Response::HTTP_OK, array $headers = []) {
		if (! $this->user ()->isGuest ()) {
			$headers [Config::TOKEN_KEY] = $this->token ();
			$headers [Config::IM_KEY] = Crypt::encrypt ( ( string ) $this->user () );
		}
		return response ( $content, $status, $headers );
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
		if (! $this->user ()->isGuest ()) {
			$headers [Config::TOKEN_KEY] = $this->token ();
			$headers [Config::IM_KEY] = Crypt::encrypt ( ( string ) $this->user () );
			$headers ['Content-Type'] = 'application/json';
		}
		return response ()->json ( [ 
				'message' => $message ? $message : '',
				'data' => $data ? $data : [ ] 
		], $status, $headers );
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
				'message' => $message ? $message : '',
				'data' => $data ? $data : [ ] 
		] );
	}
	/**
	 * set the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Response $response        	
	 * @return \Illuminate\Http\Response
	 */
	public function setResponseToken($response) {
		return $response->header ( Config::TOKEN_KEY, $this->token (), true );
	}
}
