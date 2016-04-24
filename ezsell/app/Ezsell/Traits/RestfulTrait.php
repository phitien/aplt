<?php

namespace App\Ezsell\Traits;

use GuzzleHttp\Client;
use App\Ezsell\Config\Config;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\ClientException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Facades\Crypt;
use App\User;

trait RestfulTrait {
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $formParams        	
	 * @param array $options        	
	 */
	protected function restful_post(string $url, array $formParams = [], array $options = []) {
		$client = $this->createClient ();
		try {
			$response = $client->post ( $url, array_merge ( $this->getStandardRequestParams (), [ 
					'form_params' => $formParams 
			], $options ) );
			return $this->setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return $this->setParamsFromResponse ( $e->getResponse () );
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
	 */
	protected function restful_put(string $url, array $query = [], array $formParams = [], array $options = []) {
		$client = $this->createClient ();
		try {
			$response = $client->put ( $url, array_merge ( $this->getStandardRequestParams ( $query ), [ 
					'form_params' => $formParams 
			], $options ) );
			return $this->setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return $this->setParamsFromResponse ( $e->getResponse () );
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
	 */
	protected function restful_delete(string $url, array $query = [], array $formParams = [], array $options = []) {
		$client = $this->createClient ();
		try {
			$response = $client->delete ( $url, array_merge ( $this->getStandardRequestParams ( $query ), [ 
					'form_params' => $formParams 
			], $options ) );
			return $this->setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return $this->setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			// redirect ( '/error' );
		}
	}
	/**
	 *
	 * @param string $url        	
	 * @param array $query        	
	 * @param array $options        	
	 */
	protected function restful_get(string $url, array $query = [], array $options = []) {
		$client = $this->createClient ();
		try {
			$response = $client->get ( $url, array_merge ( $this->getStandardRequestParams ( $query ), [ ], $options ) );
			return $this->setParamsFromResponse ( $response );
		} catch ( ClientException $e ) {
			return $this->setParamsFromResponse ( $e->getResponse () );
		} catch ( Exception $e ) {
			// redirect ( '/error' );
		}
	}
	/**
	 *
	 * @return \GuzzleHttp\Client
	 */
	protected function createClient() {
		$client = new Client ();
		return $client;
	}
	/**
	 *
	 * @param array $query        	
	 * @return array
	 */
	protected function getStandardRequestParams(array $query = []) {
		return [ 
				'base_uri' => Config::IM_BASE_URL,
				'headers' => [ 
						Config::IM_TOKEN_KEY => $this->token (),
						'baseUrl' => $this->getBaseUrl () 
				],
				'query' => $query 
		];
	}
	/**
	 *
	 * @param ResponseInterface $response        	
	 * @return ResponseInterface
	 */
	protected function setParamsFromResponse(ResponseInterface $response) {
		if ($response->getStatusCode () == Response::HTTP_OK) {
			try {
				$this->setToken ( $response->getHeader ( Config::IM_TOKEN_KEY ) [0] );
			} catch ( Exception $e ) {
			}
			try {
				$this->setUser ( new User ( json_decode ( Crypt::decrypt ( $response->getHeader ( Config::IM_KEY ) [0] ), true ) ) );
			} catch ( Exception $e ) {
				$this->setUer ( User::getGuest () );
			}
		}
		return $response;
	}
}
