<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\UserExtension;

trait ExtensionTrait
{
	protected $extension;
	/**
	 *
	 * @return \App\UserExtension
	 */
	public function extension() {
		if (! $this->extension)
			$this->extension = new UserExtension ( $this->json );
		return $this->extension;
	}
}
