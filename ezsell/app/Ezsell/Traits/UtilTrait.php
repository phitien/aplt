<?php

namespace App\Ezsell\Traits;

use View;
use Illuminate\Support\Facades\Storage;
use Html;
use App\Ezsell\Models\Role;
use App\Ezsell\Config\Config;

trait UtilTrait {
	/**
	 * Build App\Ezsell\RolesActions class
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
				'namespace' => 'App\Ezsell\Config',
				'classname' => 'RolesActions',
				'constants' => [ 
						'MAPS' => Html::decode ( View::make ( 'IM.classgenerator.RolesActions.maps', [ 
								'roles' => $items 
						] )->render () ) 
				] 
		] )->render () );
		
		Storage::disk ( 'im' )->put ( 'Config/RolesActions.php', $contents );
	}
}
