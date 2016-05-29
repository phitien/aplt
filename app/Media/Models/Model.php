<?php

namespace App\Media\Models;

use App\Media\Traits\AllTrait;
use App\Shared\Models\Model as SharedModel;

class Model extends SharedModel {
	protected $connection = 'media';
	/**
	 * Traits
	 */
	use AllTrait;
}
