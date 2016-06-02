<?php

namespace App\Shared\Traits;

use GuzzleHttp\Client;
use App\Shared\Config;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\ClientException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Models\User;
use GuzzleHttp\Cookie\CookieJar;

trait RestfulTrait {
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
	protected static function setParamsFromResponse(ResponseInterface $response, CookieJar $jar = NULL) {
		try {
			if ($arr = $response->getHeader ( Config::SESSION_KEY )) {
				static::setUser ( new User ( json_decode ( static::decrypt ( $cookie->getValue () ), true ) ) );
			}
			
			if ($jar) {
				foreach ( $jar->getIterator () as $cookie ) {
					if ($cookie->getName () == Config::TOKEN_KEY) {
						static::setToken ( $cookie->getValue () );
						break;
					}
				}
			}
		} catch ( Exception $e ) {
			static::setToken ( Config::INVALID_TOKEN );
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
			$jar = new CookieJar ();
			$response = $client->post ( $url, array_merge ( static::getStandardRequestParams (), [ 
					'form_params' => $formParams,
					'cookies' => $jar 
			], $options ) );
			return static::setParamsFromResponse ( $response, $jar );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			dd ( $e );
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
			$jar = new CookieJar ();
			$response = $client->post ( $url, array_merge ( static::getStandardRequestParams (), [ 
					'form_params' => $formParams,
					'cookies' => $jar 
			], $options ) );
			return static::setParamsFromResponse ( $response, $jar );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			dd ( $e );
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
			$jar = new CookieJar ();
			$response = $client->post ( $url, array_merge ( static::getStandardRequestParams (), [ 
					'form_params' => $formParams,
					'cookies' => $jar 
			], $options ) );
			return static::setParamsFromResponse ( $response, $jar );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			dd ( $e );
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
			$jar = new CookieJar ();
			$response = $client->get ( $url, array_merge ( static::getStandardRequestParams ( $query ), [ 
					'cookies' => $jar 
			], $options ) );
			return static::setParamsFromResponse ( $response, $jar );
		} catch ( ClientException $e ) {
			return static::setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			dd ( $e );
		}
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $options        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function restful_upload($file) {
		$client = static::createClient ();
		try {
			$jar = new CookieJar ();
			$response = $client->request ( 'POST', '/media', [ 
					'cookies' => $jar,
					'base_uri' => Config::MEDIA_BASE_URL,
					'headers' => [ 
							Config::TOKEN_KEY => static::getToken (),
							'DOMAIN' => request ()->server->get ( 'SERVER_NAME' ) 
					],
					'multipart' => [ 
							[ 
									'name' => 'image',
									'contents' => fopen ( $file->getRealPath (), 'r' ) 
							] 
					] 
			] );
			$json = static::json_decode ( $response->getBody (), true );
			return $json ['data'];
		} catch ( Exception $e ) {
			dd ( $e );
		}
	}
}