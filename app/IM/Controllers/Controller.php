<?php

namespace App\IM\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\IM\Utils;
use App\IM\Response\Status;
use JWTAuth;

abstract class Controller extends BaseController implements IController {
	/**
	 * Shortcut of Utils::jsonResponse
	 *
	 * @param unknown $message        	
	 * @param unknown $data        	
	 * @param unknown $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return Utils::jsonResponse ( $message, $data, $status, $headers, $options );
	}
	/**
	 * Shortcut of Utils::encode
	 *
	 * @param string $str        	
	 */
	protected function encode(string $str) {
		return Utils::encode ( $str );
	}
	/**
	 *
	 * @param unknown $credentials        	
	 */
	protected function doLogin($credentials) {
		$credentials ['active'] = 1;
		try {
			// verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt ( $credentials )) {
				return $this->jsonResponse ( 'invalid_credentials', null, Status::Unauthorized );
			}
		} catch ( JWTException $e ) {
			// something went wrong
			return $this->jsonResponse ( 'could_not_create_token', null, Status::InternalServerError );
		}
		// if no errors are encountered we can return a JWT
		return $this->jsonResponse ( null, $token );
	}
}