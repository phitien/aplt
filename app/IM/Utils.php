<?php

namespace App\IM;

use App\IM\Response\Status;
use View;
use Illuminate\Support\Facades\Storage;
use Html;
use App\IM\Models\Role;

class Utils {
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
		return response ()->json ( [ 
				'message' => $message,
				'data' => $data 
		], $status, $headers, $options );
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
				'namespace' => 'App\IM',
				'classname' => 'RolesActions',
				'public_static_vars' => [ 
						'maps' => Html::decode ( View::make ( 'IM.RolesActions.maps', [ 
								'roles' => $items 
						] )->render () ) 
				] 
		] )->render () );
		
		Storage::disk ( 'im' )->put ( 'RolesActions.php', $contents );
	}
}
