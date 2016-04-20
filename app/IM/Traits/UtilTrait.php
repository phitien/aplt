<?php

namespace App\IM\Traits;

use View;
use Illuminate\Support\Facades\Storage;
use Html;
use App\IM\Models\Role;
use App\IM\Config\Config;

trait UtilTrait {
	/**
	 * Build App\IM\RolesActions class
	 *
	 * @return void
	 */
	public function buildRolesActions() {
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
	 *
	 * @return string
	 */
	public static function getBaseUrl() {
		return request ()->get ( 'baseUrl', (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' ) + '/api' );
	}
}
