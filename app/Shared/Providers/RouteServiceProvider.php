<?php

namespace App\Shared\Providers;

use App\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends BaseRouteServiceProvider {
	/**
	 * Root namespace
	 *
	 * @var string $namespace
	 */
	protected $namespace = 'App\Shared\Controllers';
	protected function mapWebRoutes(Router $router) {
		switch (request ()->server ( 'SERVER_NAME' )) {
			case 'im.ezsell.com' :
				$router->group ( [ 
						'namespace' => $this->namespace = 'App\IM\Controllers',
						'middleware' => 'web' 
				], function ($router) {
					require app_path ( 'IM/Http/routes.php' );
				} );
				break;
			case 'media.ezsell.com' :
				$router->group ( [ 
						'namespace' => $this->namespace = 'App\Media\Controllers',
						'middleware' => 'web' 
				], function ($router) {
					require app_path ( 'Media/Http/routes.php' );
				} );
				break;
			case 'www.ezsell.com' :
			default :
				$router->group ( [ 
						'namespace' => $this->namespace = 'App\Platform\Controllers',
						'middleware' => 'web' 
				], function ($router) {
					require app_path ( 'Platform/Http/routes.php' );
				} );
				break;
		}
	}
}
