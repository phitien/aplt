<?php

namespace App\IM\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\IM\Utils;
use App\IM\Response\Status;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
use App\IM\Middleware\AuthorizationMiddleware;

abstract class Controller extends BaseController implements IController {
	protected $_im_middlewares = [ ];
	protected $_im_middlewaresOptions = [ ];
	protected $_im_middlewaresExceptOption = [ ];
	/**
	 */
	public function __construct() {
		$this->middleware ( $this->getIMMiddlewares (), $this->getIMMiddlewaresOptions () );
	}
	protected function getIMMiddlewares() {
		$items = $this->_im_middlewares ? $this->_im_middlewares : [ ];
		$items [count ( $items )] = AuthorizationMiddleware::class;
		return $items;
	}
	protected function getIMMiddlewaresOptions() {
		$options = $this->_im_middlewaresOptions ? $this->_im_middlewaresOptions : [ ];
		$options ['except'] = $this->_im_middlewaresExceptOption ? $this->_im_middlewaresExceptOption : [ ];
		return $options;
	}
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
		} catch ( Exception $e ) {
			// something went wrong
			return $this->jsonResponse ( 'could_not_create_token', null, Status::InternalServerError );
		}
		// if no errors are encountered we can return a JWT
		return $this->jsonResponse ( 'login_successfully', $token );
	}
}