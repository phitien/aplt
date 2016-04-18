<?php

namespace App\IM\Controllers;

use App\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Http\Response;
use App\IM\Controllers\Traits\RegisterTrait;
use App\IM\Controllers\Traits\ActivateTrait;
use App\IM\Controllers\Traits\DeactivateTrait;
use App\IM\Controllers\Traits\ProfileTrait;
use App\IM\Controllers\Traits\SocietyTrait;

class AccountController extends AuthenticableController {
	/**
	 * Traits
	 */
	use RegisterTrait, ActivateTrait, DeactivateTrait, ProfileTrait, SocietyTrait;
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'login',
					'code',
					'register',
					'activate' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ 
					'login',
					'code',
					'register',
					'activate' 
			] 
	];
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		if ($msg = $this->validatePassword ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$new_password = $request->request->get ( 'password' );
		if (Hash::check ( $new_password, $this->user ()->password )) {
			return $this->jsonResponse ( 'password_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		$credentials = [ 
				'email' => $this->user ()->email,
				'password' => $this->user ()->changePassword ( $new_password ) 
		];
		return $this->updateJsonResponse ( $this->doLogin ( $credentials ), 'password_changed', null );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function reset(Request $request) {
		// TODO
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function email(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		$email = $request->request->get ( 'email' );
		if ($email == $this->user ()->email) {
			return $this->jsonResponse ( 'email_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		if ($msg = $this->validateEmail ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		static::mailTo ( $this->user (), 'email', 'Email changed', [ 
				'title' => 'Email changed',
				'receiver' => $this->user (),
				'email' => $email 
		] );
		$url = $this->getRequestBaseUrl () . '/api/activate/' . $this->user ()->changeEmail ( $email );
		static::mailTo ( $this->user (), 'register', 'Welcome to EZSell', [ 
				'title' => 'Welcome to EZSell',
				'receiver' => $this->user (),
				'url' => $url 
		] );
		return $this->updateJsonResponse ( $this->doLogout (), 'user_email_changed', 'Please active your account at ' . $this->user ()->email );
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function account(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		$name = $request->request->get ( 'name' );
		if ($name == $this->user ()->name) {
			return $this->jsonResponse ( 'name_not_changed', null, Response::HTTP_BAD_REQUEST );
		}
		if ($msg = $this->validateName ( $request->request->all () )) {
			return $this->jsonResponse ( $msg, null, Response::HTTP_BAD_REQUEST );
		}
		$this->user ()->changeName ( $name );
		return $this->jsonResponse ( 'name_changed', null );
	}
}
