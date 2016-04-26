<?php

namespace App\Ezsell\Traits;

trait ApiCallRestfulTrait {
	/**
	 *
	 * @param array $data[email,email_confirmation,password,password_confirmation]        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallRegister(array $data = []) {
		return static::restful_post ( 'api/register', $data );
	}
	/**
	 *
	 * @param string $code        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallActivate(string $code = '') {
		return static::restful_get ( 'api/activate/' . $code );
	}
	/**
	 *
	 * @param array $data[email]        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallCode(array $data = []) {
		return static::restful_post ( 'api/code', $data );
	}
	/**
	 *
	 * @param array $credentials        	
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallLogin(array $credentials = []) {
		return static::restful_post ( 'api/login', $credentials );
	}
	/**
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallLogout() {
		return static::restful_post ( 'api/logout' );
	}
	/**
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallDeactive(string $password = '') {
		return static::restful_post ( 'api/deactivate', [ 
				'password' => $password 
		] );
	}
	/**
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallProfile() {
		return static::restful_get ( 'api/profile' );
	}
	/**
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected static function apiCallUpdateProfile(array $data = []) {
		return static::restful_post ( 'api/profile', $data );
	}
}
