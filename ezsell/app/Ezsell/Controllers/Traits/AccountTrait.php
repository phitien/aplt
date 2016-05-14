<?php

namespace App\Ezsell\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Ezsell\Config\Config;

trait AccountTrait {
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		return $this->process ( 'password', func_get_args () );
	}
	protected function ppostPassword(Request $request) {
		$data = $request->only ( 'current_password', 'password', 'password_confirmation' );
		$response = static::apiCallPassword ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( view ( 'password', [ 
					'appMessage' => "Hehe mật khẩu đổi rồi đấy, an toàn rồi :D" 
			] ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'password', [ 
					'appMessage' => "Hỏng rồi, không đổi được mật khẩu, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	protected function pgetPassword(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'login' ) );
		else
			return $this->response ( view ( 'password' ) );
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function email(Request $request) {
		return $this->process ( 'email', func_get_args () );
	}
	protected function ppostEmail(Request $request) {
		$data = $request->only ( 'current_password', 'email', 'email_confirmation' );
		$response = static::apiCallEmail ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( view ( 'email', [ 
					'appMessage' => "Hehe email đổi rồi đấy, đăng nhập bằng email mới đi ha :D" 
			] ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'email', [ 
					'appMessage' => "Hỏng rồi, không đổi được email rồi, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	protected function pgetEmail(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'login' ) );
		else
			return $this->response ( view ( 'email' ) );
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function account(Request $request) {
		return $this->process ( 'account', func_get_args () );
	}
	protected function ppostAccount(Request $request) {
		$data = $request->only ( 'current_password', 'name' );
		$response = static::apiCallAccount ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( view ( 'account', [ 
					'appMessage' => "Hehe account đổi rồi đấy :D" 
			] ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'account', [ 
					'appMessage' => "Hỏng rồi, không đổi được account, lý do vì {$data['message']}. Thử lại phát đi." 
			] ), $response->getStatusCode () );
		}
	}
	protected function pgetAccount(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'login' ) );
		else
			return $this->response ( view ( 'account' ) );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function reset(Request $request) {
		// TODO
		return $this->process ( 'reset', func_get_args () );
	}
}
