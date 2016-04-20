<?php

namespace App\Ezsell\Traits;

use GuzzleHttp\Client;
use App\Ezsell\Config\Config;
use Illuminate\Http\Response;

trait RestfulTrait {
	protected function restful_post(string $url, $formParams) {
		$client = new Client ( [ 
				'cookie' => true 
		] );
		$response = $client->request ( 'POST', Config::IM_BASE_URL . $url, [ 
				'form_params' => $formParams 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $response;
		} else {
			// redirect ( '/error' );
		}
	}
}
