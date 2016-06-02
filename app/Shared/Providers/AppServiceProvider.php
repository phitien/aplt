<?php

namespace App\Shared\Providers;

use App\Providers\AppServiceProvider as BaseAppServiceProvider;

class AppServiceProvider extends BaseAppServiceProvider {
	/**
	 * Create a new service provider instance.
	 *
	 * @param \Illuminate\Contracts\Foundation\Application $app        	
	 * @return void
	 */
	public function boot() {
		parent::boot ();
		$this->setupDatabaseConnection ();
	}
	protected function setupDatabaseConnection() {
		switch (request ()->server ( 'SERVER_NAME' )) {
			case 'im.ezsell.com' :
				config ( [ 
						'database.default' => 'im',
						'auth.providers.users.model' => \App\IM\Models\User::class,
						'jwt.user' => \App\IM\Models\User::class 
				] );
				break;
			case 'media.ezsell.com' :
				config ( [ 
						'database.default' => 'ezsell',
						'auth.providers.users.model' => \App\Shared\Models\User::class,
						'jwt.user' => \App\Shared\Models\User::class 
				] );
				break;
			case 'www.ezsell.com' :
			default :
				config ( [ 
						'database.default' => 'app',
						'auth.providers.users.model' => \App\Shared\Models\User::class,
						'jwt.user' => \App\Shared\Models\User::class 
				] );
				
				break;
		}
	}
}
