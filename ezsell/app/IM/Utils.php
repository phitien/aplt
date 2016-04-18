<?php

namespace App\IM;

use View;
use Illuminate\Support\Facades\Storage;
use Html;
use App\IM\Models\Role;
use App\IM\Config\Config;
use JWTAuth;
use App\User;
use Exception;
use App\IM\Exceptions\UserNotFound;
use App\IM\Exceptions\TokenNotFound;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class Utils {
	/**
	 *
	 * @var string
	 */
	private static $__token;
	/**
	 *
	 * @return string token
	 */
	public static function token() {
		if (! static::$__token) {
			static::$__token = Cookie::get ( Config::TOKEN_KEY, static::$__token = JWTAuth::getToken () );
		}
		return static::$__token;
	}
	/**
	 *
	 * @var User
	 */
	private static $__user;
	/**
	 *
	 * @return User
	 */
	public static function user($throwExceptionIfNotFound = false) {
		if (! static::$__user || $throwExceptionIfNotFound) {
			$token = static::token ();
			if ($throwExceptionIfNotFound) {
				if (! $token) {
					throw new TokenNotFound ();
				} else {
					static::$__user = JWTAuth::authenticate ( $token );
					if (! static::$__user || static::$__user->isGuest ())
						throw new UserNotFound ();
				}
			} else {
				try {
					static::$__user = JWTAuth::authenticate ( $token );
				} catch ( Exception $e ) {
				}
				if (! static::$__user)
					static::$__user = User::getGuest ();
			}
		}
		return static::$__user;
	}
	/**
	 *
	 * @param number $status        	
	 * @param array $headers        	
	 * @return Response
	 */
	public static function response($status = Response::HTTP_OK, array $headers = []) {
		return static::setResponseCookieToken ( response ( '', $status, $headers ), static::token () );
	}
	/**
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function jsonResponse($message = null, $data = null, $status = Response::HTTP_OK, array $headers = []) {
		return static::setResponseCookieToken ( response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers ), static::token () );
	}
	/**
	 *
	 * @param Response $response        	
	 * @param string $message        	
	 * @param string $data        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function updateJsonResponse(JsonResponse $response, $message = null, $data = null) {
		return $response->setData ( [ 
				'message' => $message,
				'data' => $data 
		] );
	}
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encode(string $str) {
		return bcrypt ( $str );
	}
	/**
	 * Build App\IM\RolesActions class
	 *
	 * @return void
	 */
	public static function buildRolesActions() {
		$items = [ ];
		$roles = Role::all ();
		foreach ( $roles as $role ) {
			$items [$role->code] = $role->getActions ();
		}
		$contents = Html::decode ( View::make ( 'IM.classgenerator.RolesActions.class', [ 
				'php' => '<?php',
				'namespace' => 'App\IM\Config',
				'classname' => 'RolesActions',
				'constants' => [ 
						'MAPS' => Html::decode ( View::make ( 'IM.classgenerator.RolesActions.maps', [ 
								'roles' => $items 
						] )->render () ) 
				] 
		] )->render () );
		
		Storage::disk ( 'im' )->put ( 'Config/RolesActions.php', $contents );
	}
	/**
	 * set the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Response $response        	
	 * @param string $cookie        	
	 * @return \Illuminate\Http\Response
	 */
	public static function setResponseCookieToken($response, $cookie) {
		$expiringTime = time () + Config::TOKEN_EXPIRING_TIME;
		return $response->withCookie ( Config::TOKEN_KEY, $cookie, $expiringTime );
	}
	/**
	 * unset the IM token to the response cookies.
	 *
	 * @param \Illuminate\Http\Response $response        	
	 * @param string $cookie        	
	 * @return \Illuminate\Http\Response
	 */
	public static function unsetResponseCookieToken($response) {
		return $response->withCookie ( Config::TOKEN_KEY, Cookie::forget ( Config::TOKEN_KEY ) );
	}
	/**
	 *
	 * @return string
	 */
	public static function getRequestBaseUrl() {
		return (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' );
	}
	/**
	 *
	 * @param string $subject        	
	 * @return string
	 */
	public static function getMailSubject($subject) {
		return Config::MAIL_SUBJECT_PREFIX . $subject;
	}
}