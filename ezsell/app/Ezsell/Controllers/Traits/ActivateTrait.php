<?php

namespace App\Ezsell\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait  ActivateTrait {
	/**
	 * Activate user
	 *
	 * @param Request $request        	
	 * @param string $code        	
	 * @return Response
	 */
	public function activate(Request $request, $code) {
		$data = User::decodeActivationCode ( $code );
		if (! $data)
			return $this->jsonResponse ( 'invalid_activation_code', null, Response::HTTP_BAD_REQUEST );
		if (! ($user = User::find ( $data [1] )))
			return $this->jsonResponse ( 'invalid_activation_code', null, Response::HTTP_BAD_REQUEST );
		if ($user->email != $data [2])
			return $this->jsonResponse ( 'invalid_activation_code', null, Response::HTTP_BAD_REQUEST );
		if (! $user->activate ( $code ))
			return $this->jsonResponse ( 'invalid_activation_code_expired', null, Response::HTTP_BAD_REQUEST );
		$url = $user->baseUrl ? $user->baseUrl : '/';
		header ( "Location: $url" );
		exit ();
	}
	/**
	 * Send activation code
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function code(Request $request) {
		$email = $request->get ( 'email' );
		$user = User::where ( 'email', '=', $email )->first ();
		if ($user) {
			if (! $user->isActivated ()) {
				$this->resendActivationEmail ( $user );
				return $this->jsonResponse ( 'activation_code_sent', 'Please active your account at ' . $user->email );
			} else {
				return $this->jsonResponse ( 'user_already_activated', null, Response::HTTP_BAD_REQUEST );
			}
		} else {
			return $this->jsonResponse ( 'email_not_found', null, Response::HTTP_BAD_REQUEST );
		}
	}
}
