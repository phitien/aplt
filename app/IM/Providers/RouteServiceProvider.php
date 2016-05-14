<?php

namespace App\IM\Providers;

use App\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends BaseRouteServiceProvider {
	/**
	 * Root namespace
	 *
	 * @var string $namespace
	 */
	protected $namespace = 'App\IM\Controllers';
	protected function mapWebRoutes(Router $router) {
		$router->group ( [ 
				'namespace' => $this->namespace,
				'middleware' => 'web' 
		], function ($router) {
			require app_path ( 'IM/Http/routes.php' );
		} );
	}
}
