<?php

namespace App\Shared\Providers;

use Illuminate\View\ViewServiceProvider as BaseViewServiceProvider;

class ViewServiceProvider extends BaseViewServiceProvider {
	/**
	 * Register the view environment.
	 *
	 * @return void
	 */
	public function registerFactory() {
		$this->app->singleton ( 'view', function ($app) {
			// Next we need to grab the engine resolver instance that will be used by the
			// environment. The resolver will be used by an environment to get each of
			// the various engine implementations such as plain PHP or Blade engine.
			$resolver = $app ['view.engine.resolver'];
			
			$finder = $app ['view.finder'];
			switch (request ()->server ( 'SERVER_NAME' )) {
				case 'www.ezsell.com' :
					$env = new \App\Platform\View\Factory ( $resolver, $finder, $app ['events'] );
					break;
				case 'im.ezsell.com' :
				case 'media.ezsell.com' :
				default :
					$env = new \App\Shared\View\Factory ( $resolver, $finder, $app ['events'] );
					break;
			}
			
			// We will also set the container instance on this view environment since the
			// view composers may be classes registered in the container, which allows
			// for great testable, flexible composers for the application developer.
			$env->setContainer ( $app );
			
			$env->share ( 'app', $app );
			
			return $env;
		} );
	}
}
