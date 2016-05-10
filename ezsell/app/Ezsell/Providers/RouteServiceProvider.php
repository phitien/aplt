<?php

namespace App\Ezsell\Providers;

use App\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends BaseRouteServiceProvider {
	/**
	 * Root namespace
	 *
	 * @var string $namespace
	 */
	protected $namespace = 'App\Ezsell';
	protected function mapWebRoutes(Router $router) {
		$router->group ( [ 
				'namespace' => $this->namespace,
				'middleware' => 'web' 
		], function ($router) {
			require app_path ( 'Ezsell/Http/routes.php' );
		} );
	}
}
