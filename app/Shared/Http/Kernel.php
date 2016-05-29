<?php

namespace App\Shared\Http;

use App\Http\Kernel as BaseKernel;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;

class Kernel extends BaseKernel {
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [ 
			\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class 
	];
	
	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [ 
			'web' => [ 
					\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
					\App\Http\Middleware\EncryptCookies::class,
					\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
					\Illuminate\Session\Middleware\StartSession::class,
					\Illuminate\View\Middleware\ShareErrorsFromSession::class 
			],
			
			'api' => [ 
					'throttle:60,1' 
			] 
	];
	
	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [ 
			'auth' => \App\Http\Middleware\Authenticate::class,
			'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
			'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
			'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
			'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class 
	];
	/**
	 * Create a new HTTP kernel instance.
	 *
	 * @param \Illuminate\Contracts\Foundation\Application $app        	
	 * @param \Illuminate\Routing\Router $router        	
	 * @return void
	 */
	public function __construct(Application $app, Router $router) {
		switch ($_SERVER ['SERVER_NAME']) {
			case 'im.ezsell.com' :
				$this->routeMiddleware ['im.authentication'] = \App\IM\Middleware\Authentication::class;
				$this->routeMiddleware ['im.authorization'] = \App\IM\Middleware\Authorization::class;
				break;
			case 'media.ezsell.com' :
				$this->routeMiddleware ['im.authentication'] = \App\Media\Middleware\Authentication::class;
				$this->routeMiddleware ['im.authorization'] = \App\Media\Middleware\Authorization::class;
				break;
			case 'www.ezsell.com' :
				array_push ( $this->middlewareGroups ['web'], \App\Shared\Middleware\VerifyCsrfToken::class );
				array_push ( $this->middlewareGroups ['web'], \App\Platform\Middleware\Prehandle::class );
				$this->routeMiddleware ['im.location'] = \App\Platform\Middleware\Location::class;
				$this->routeMiddleware ['im.authentication'] = \App\Platform\Middleware\Authentication::class;
				$this->routeMiddleware ['im.authorization'] = \App\Platform\Middleware\Authorization::class;
				break;
		}
		parent::__construct ( $app, $router );
	}
}
