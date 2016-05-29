<?php

namespace App\IM\Traits;

use App\Shared\Traits\UtilTrait;
use App\IM\Models\Role;
use Storage, View, Html;

trait AllTrait
{
	use MailerTrait,
		ResponseTrait,
		UserTrait,
		UtilTrait;
	
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
