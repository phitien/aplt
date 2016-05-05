<?php

namespace App\Ezsell\Controllers\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use View;

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
			return $this->response ( View::make ( 'activate', [ 
					'ezsellMessage' => "Hehe kích hoạt ok rồi đấy. Lướt thôi :D" 
			] ) );
		} else {
			$data = json_decode ( $response->getBody (), true );
			return $this->response ( View::make ( 'activate', [ 
					'ezsellMessage' => "Hỏng rồi, đăng ký không được, lý do vì {$data['message']}. Thử đăng ký lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	/**
	 * Send activation code
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function code(Request $request) {
		if ($request->isMethod ( 'post' )) {
			return $this->apiCode ( $request );
		} else {
			return $this->showCode ( $request );
		}
	}
	protected function apiCode(Request $request) {
		$email = $request->get ( 'email' );
		if ($msg = $this->emailValidator ( [ 
				'email' => $email 
		] )) {
			return $this->response ( View::make ( 'code', [ 
					'ezsellMessage' => "Hỏng rồi, không gửi được thư kích hoạt, lý do vì {$msg}. Thử lại phát đi." 
			] ), Response::HTTP_BAD_REQUEST );
		}
		$response = static::apiCallCode ( [ 
				'email' => $email 
		] );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( View::make ( 'code', [ 
					'ezsellMessage' => "Hehe thư kích hoạt gửi rồi đấy, đăng nhập email và kích hoạt ngay đi nhé :)." 
			] ) );
		} else {
			$data = json_decode ( $response->getBody (), true );
			return $this->response ( View::make ( 'code', [ 
					'ezsellMessage' => "Hỏng rồi, không gửi được thư kích hoạt, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	protected function showCode(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( View::make ( 'code' ) );
		else
			return $this->redirect ();
	}
	protected function emailValidator(array $data) {
		$validator = Validator::make ( $data, [ 
				'email' => 'required|email|max:255' 
		] );
		if ($validator->fails ()) {
			return 'invalid_email';
		}
	}
}
