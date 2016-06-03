<?php

namespace App\Platform\Traits;

use App\Platform\Config;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Platform\Response\PageResponseData;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

trait ResponseTrait {
	/**
	 *
	 * @param BaseResponse $response        	
	 */
	protected static function addHeaders(BaseResponse $response) {
		$response = static::addCookieToResponse ( $response, Config::TOKEN_KEY, static::getToken () );
		$response = static::addCookieToResponse ( $response, Config::LOCATION_KEY, static::getLocationId () );
		$response = static::addCookieToResponse ( $response, Config::MODE, static::getMode () );
		$response = $response->header ( Config::TOKEN_KEY, static::getToken (), true );
		return $response;
	}
	/**
	 *
	 * @param BaseResponse $response        	
	 */
	protected static function clearHeaders(BaseResponse $response) {
		$response = static::addCookieToResponse ( $response, Config::TOKEN_KEY, null );
		$response = static::addCookieToResponse ( $response, Config::MODE, null );
		return $response;
	}
	/**
	 *
	 * @var PageResponseData $_pageResponseData
	 */
	private $_pageResponseData;
	protected function setPageResponseData(PageResponseData $pageResponseData) {
		$this->_pageResponseData = $pageResponseData;
		return $this->_pageResponseData;
	}
	/**
	 *
	 * @return PageResponseData
	 */
	protected function getPageResponseData() {
		if (! $this->_pageResponseData) {
			$this->_pageResponseData = new PageResponseData ( null );
		}
		return $this->_pageResponseData;
	}
	/**
	 *
	 * @return Response $response
	 */
	protected function getLoginResponse() {
		if (request ()->ajax ())
			return $this->jsonResponse ( 'login_page', $this->getPageResponseData ()->setType ( 'LoginPage' ) );
		else
			return $this->response ( view ( 'base', $this->getPageResponseData ()->setType ( 'LoginPage' ) ) );
	}
	/**
	 *
	 * @return Response $response
	 */
	protected function getHomePageResponse() {
		$this->getPageResponseData ()->setType ( 'HomePage' )->setShowBanner ( true )->setShowLeft ( 2 )->setShowRight ( 2 );
		if (request ()->ajax ())
			return $this->jsonResponse ( 'home_page', $this->getPageResponseData () );
		else
			return $this->response ( view ( 'base', $this->getPageResponseData () ) );
	}
	/**
	 *
	 * @return PageResponseData
	 */
	protected function getPageResponseDataNoBanner() {
		return $this->getPageResponseData ()->setShowBanner ( false );
	}
	/**
	 *
	 * @return Response $response
	 */
	protected function getTransMessage($message, $data) {
		if ($data) {
			$reason = $data ['message'] ? $data ['message'] : $data;
			return trans ( $message, [ 
					'reason' => trans ( "messages.errors.{$reason}" ) 
			] );
		} else
			trans ( $message );
	}
	/**
	 * Build response
	 *
	 * @param string $to        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param bool $secure        	
	 * @return Response
	 */
	public function redirect($to = Config::HOME_PAGE, $status = 302, $headers = [], $secure = null) {
		return redirect ( $to, $status, $headers, $secure );
	}
	/**
	 *
	 * @param string $content        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return Response
	 */
	public function response($content, $status = Response::HTTP_OK, array $headers = []) {
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
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data instanceof PageResponseData ? $data->getData () : $data 
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
				'message' => $message,
				'data' => $data instanceof PageResponseData ? $data->getData () : $data 
		] );
	}
}
