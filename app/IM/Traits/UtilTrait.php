<?php

namespace App\IM\Traits;

use View;
use Illuminate\Support\Facades\Storage;
use Html;
use App\IM\Models\Role;
use App\IM\Config\Config;

trait UtilTrait {
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encode($str) {
		return bcrypt ( $str );
	}
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encrypt($str) {
		return base64_encode ( $str );
	}
	
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function decrypt($str) {
		return base64_decode ( $str );
	}
	/**
	 * Build App\IM\RolesActions class
	 *
	 * @return void
	 */
	public function buildRolesActions() {
		$className = 'RolesActions';
		
		$items = [ ];
		$roles = Role::all ();
		foreach ( $roles as $role ) {
			$items [$role->code] = $role->getActions ();
		}
		static::renderTrait ( "Config/{$className}Trait", [ 
				'private_static_vars' => [ 
						'__maps' => Html::decode ( View::make ( 'classgenerator.rolesactions.maps', [ 
								'roles' => $items 
						] )->render () ) 
				] 
		] );
		static::renderClass ( "Config/{$className}" );
	}
	public static function renderTrait($filePath, $data = []) {
		$data = array_merge ( [ 
				'php' => '<?php' 
		], $data );
		$contents = Html::decode ( View::make ( 'classgenerator.rolesactions.trait', $data )->render () );
		Storage::disk ( 'app' )->put ( "{$filePath}.php", $contents );
	}
	public static function renderClass($filePath, $data = []) {
		$data = array_merge ( [ 
				'php' => '<?php' 
		], $data );
		$contents = Html::decode ( View::make ( 'classgenerator.rolesactions.class', $data )->render () );
		Storage::disk ( 'app' )->put ( "{$filePath}.php", $contents );
	}
	/**
	 *
	 * @return string
	 */
	public static function getBaseUrl() {
		return request ()->header ( 'baseUrl', (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' ) + '/api' );
	}
}
