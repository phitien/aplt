<?php

namespace App\Ezsell\Traits;

use GuzzleHttp\Client;
use App\Ezsell\Config\Config;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\ClientException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use App\User;
use Image;

trait RestfulTrait {
	use UserTrait;
	/**
	 *
	 * @return \GuzzleHttp\Client
	 */
	protected static function createClient() {
		$client = new Client ();
		return $client;
	}
	/**
	 *
	 * @param array $query        	
	 * @return array
	 */
	protected static function getStandardRequestParams(array $query = []) {
		return [ 
				'base_uri' => Config::IM_BASE_URL,
				'headers' => [ 
						Config::TOKEN_KEY => static::getToken (),
						'baseUrl' => static::getBaseUri () 
				],
				'query' => $query 
		];
	}
	/**
	 *
	 * @param ResponseInterface $response        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function setParamsFromResponse(ResponseInterface $response) {
		try {
			static::setToken ( $response->getHeader ( Config::TOKEN_KEY ) [0] );
		} catch ( Exception $e ) {
			static::setToken ( Config::INVALID_TOKEN );
		}
		try {
			static::setUser ( new User ( json_decode ( static::decrypt ( $response->getHeader ( Config::SESSION_KEY ) [0] ), true ) ) );
		} catch ( Exception $e ) {
			static::setUser ( User::getGuest () );
		}
		return $response;
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $formParams        	
	 * @param array $options        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function restful_post(string $url, array $formParams = [], array $options = []) {
		$client = static::createClient ();
		try {
			$response = $client->post ( $url, array_merge ( static::getStandardRequestParams (), [ 
					'form_params' => $formParams 
			], $options ) );
			return static::setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			echo $e->getMessage ();
			// redirect ( '/error' );
		}
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $formParams        	
	 * @param array $options        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function restful_put(string $url, array $query = [], array $formParams = [], array $options = []) {
		$client = static::createClient ();
		try {
			$response = $client->put ( $url, array_merge ( static::getStandardRequestParams ( $query ), [ 
					'form_params' => $formParams 
			], $options ) );
			return static::setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			// redirect ( '/error' );
		}
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $formParams        	
	 * @param array $options        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function restful_delete(string $url, array $query = [], array $formParams = [], array $options = []) {
		$client = static::createClient ();
		try {
			$response = $client->delete ( $url, array_merge ( static::getStandardRequestParams ( $query ), [ 
					'form_params' => $formParams 
			], $options ) );
			return static::setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			// redirect ( '/error' );
		}
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $options        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function restful_get(string $url, array $query = [], array $options = []) {
		$client = static::createClient ();
		try {
			$response = $client->get ( $url, array_merge ( static::getStandardRequestParams ( $query ), [ ], $options ) );
			return static::setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			// redirect ( '/error' );
		}
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $formParams        	
	 * @param array $options        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function restful_upload($file) {
		ini_set ( 'post_max_size', 0 );
		ini_set ( 'client_max_body_size', 0 );
		ini_set ( 'upload_max_filesize', '1G' );
		$client = static::createClient ();
		$response = $client->post ( '/media', [ 
				'base_uri' => Config::MEDIA_BASE_URL,
				'headers' => [ 
						Config::TOKEN_KEY => static::getToken (),
						Config::SESSION_KEY => static::getUserInfoFromRequest () 
				],
				'form_params' => [ 
						'image' => Image::make ( $file )->encode () 
				] 
		] );
		print_r ( $response->getBody () );
	}
}
