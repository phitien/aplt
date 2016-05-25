<?php

namespace App\Platform\Controllers\Traits;

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
		$response = static::apiCallActivate ( $code );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ActivatePage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.activated' ) ) ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ActivatePage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.activate_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	/**
	 * Send activation code
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function code(Request $request) {
		return $this->process ( 'code', func_get_args () );
	}
	protected function ppostCode(Request $request) {
		$email = $request->get ( 'email' );
		$response = static::apiCallCode ( [ 
				'email' => $email 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'SendActivationPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.code_sent' ) ) ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'SendActivationPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.code_send_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	protected function pgetCode(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'SendActivationPage' ) ) );
		else
			return $this->redirect ();
	}
}
