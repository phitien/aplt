<?php

namespace App\Ezsell\View;

use Illuminate\View\Factory as BaseFactory;

class Factory extends BaseFactory {
	/**
	 *
	 * @var bool
	 */
	public $requireOriginalRendering = false;
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param string $view        	
	 * @param array $data        	
	 * @param array $mergeData        	
	 * @return \Illuminate\Contracts\View\View
	 */
	public function make($view, $data = [], $mergeData = []) {
		// addon to add some default options to view
		$data = $this->preProcessData ( $data );
		return parent::make ( $view, $data, $mergeData );
	}
	/**
	 *
	 * @param array $data        	
	 * @return array
	 */
	protected function preProcessData($data = []) {
		if (! $this->requireOriginalRendering) {
		}
		return $data;
	}
	/**
	 *
	 * @param unknown $view        	
	 * @param array $data        	
	 * @param array $mergeData        	
	 */
	public function create($view, $data = [], $mergeData = []) {
		$this->requireOriginalRendering = true;
		$view = $this->make ( $view, $data, $mergeData );
		return $view;
	}
}
