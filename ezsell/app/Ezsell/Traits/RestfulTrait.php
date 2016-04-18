<?php

namespace App\Ezsell\Traits;

use GuzzleHttp\Client;
use App\Ezsell\Config\Config;

trait RestfilTrait {
	protected function restful_get() {
		$client = new Client ( [ 
				'cookie' => true 
		] );
		$response = $client->request ( 'POST', Config::IM_BASE_URL . '/login', [ 
				'form_params' => $credentials 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			$cookies = $response->getHeader ( Config::IM_TOKEN_KEY );
			$json = json_decode ( $response->getBody (), true );
			$user = new User ( $json ['data'] );
			print_r ( $user->toArray () );
			foreach ( $cookies as $cookie ) {
				$cookie = SetCookie::fromString ( $cookie );
				if ($cookie->getName () == Config::IM_TOKEN_KEY) {
					$token = $cookie->getValue ();
					exit ();
					return $this->setResponseToken ( redirect ( '/' ), $this->setToken ( $token ) );
				}
			}
		}
	}
}
