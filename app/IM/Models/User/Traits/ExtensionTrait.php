<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\UserExtension;

trait ExtensionTrait
{
	protected $_extension;
	/**
	 *
	 * @return \App\UserExtension
	 */
	public function extension() {
		if (! $this->_extension)
			$this->_extension = new UserExtension ( $this->json );
		return $this->_extension;
	}
	/**
	 *
	 * @param array $attributes        	
	 */
	public function fillEx(array $attributes) {
		$this->extension ()->fill ( $attributes );
		return $this;
	}
}
