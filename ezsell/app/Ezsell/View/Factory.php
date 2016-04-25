<?php

namespace App\Ezsell\View;

use Illuminate\View\Factory as BaseFactory;
use App\Ezsell\Traits\UserTrait;
use App\Ezsell\Traits\UtilTrait;

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
		$data ['isGuest'] = static::getUser ()->isGuest ();
		$data ['user'] = static::getUser ();
		return parent::make ( $view, $data, $mergeData );
	}
}
