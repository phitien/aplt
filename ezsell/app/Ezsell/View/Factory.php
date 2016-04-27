<?php

namespace App\Ezsell\View;

use Illuminate\View\Factory as BaseFactory;
use App\Ezsell\Traits\UserTrait;
use App\Ezsell\Traits\UtilTrait;
use App\Ezsell\View\Html\Menu\Menu;
use App\Ezsell\View\Html\Menu\MenuItem;

class Factory extends BaseFactory {
	use UserTrait, UtilTrait;
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param string $view        	
	 * @param array $data        	
	 * @param array $mergeData        	
	 * @return \Illuminate\Contracts\View\View
	 */
	public function make($view, $data = [], $mergeData = []) {
		$isGuest = ( bool ) static::getUser ()->isGuest ();
		$data ['isGuest'] = $isGuest;
		$data ['user'] = static::getUser ();
		$menu = (new Menu ())->setClassName ( 'nav navbar-nav navbar-right' );
		$menu->addChild ( (new MenuItem ())->setText ( 'Home' )->setHref ( '/' ) );
		if ($isGuest) {
			$menu->addChild ( (new MenuItem ())->setText ( 'Login' )->setHref ( '/login' ) );
			$menu->addChild ( (new MenuItem ())->setText ( 'Register' )->setHref ( '/register' ) );
			$menu->addChild ( (new MenuItem ())->setText ( 'Code' )->setHref ( '/code' ) );
		} else {
			$menu->addChild ( (new MenuItem ())->setText ( 'Profile' )->setHref ( '/profile' ) );
			$menu->addChild ( (new MenuItem ())->setText ( 'Deactivate' )->setHref ( '/deactivate' ) );
			$menu->addChild ( (new MenuItem ())->setText ( 'Logout' )->setHref ( '/logout' ) );
		}
		$data ['menu'] = $menu;
		return parent::make ( $view, $data, $mergeData );
	}
}
