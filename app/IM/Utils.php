<?php

namespace App\IM;

use App\IM\Response\Status;
use View;
use Illuminate\Support\Facades\Storage;
use Html;
use App\IM\Models\Role;
use App\IM\Config\Config;
use JWTAuth;
use App\User;
use Exception;
use App\IM\Exceptions\UserNotFound;

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
		if (! static::$__token)
			static::$__token = JWTAuth::getToken ();
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
					static::$__user = User::getGuest ();
				}
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
	public static function response($status = Status::OK, array $headers = []) {
		return static::setResponseCookieToken ( response ( '', $status, $headers ), static::token () );
	}
	/**
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param number $options        	
	 * @return Response
	 */
	public static function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0) {
		return static::setResponseCookieToken ( response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers, $options ), static::token () );
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
		$contents = Html::decode ( View::make ( 'IM.RolesActions.class', [ 
				'php' => '<?php',
				'namespace' => 'App\IM\Config',
				'classname' => 'RolesActions',
				'constants' => [ 
						'MAPS' => Html::decode ( View::make ( 'IM.RolesActions.maps', [ 
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
		$config = config ( 'session' );
		$expiringTime = time () + Config::TOKEN_EXPIRING_TIME;
		$response->headers->setCookie ( new Cookie ( 'IM-TOKEN', $cookie, $expiringTime, $config ['path'], $config ['domain'], $config ['secure'], false ) );
		return $response;
	}
}
