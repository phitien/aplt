<?php

namespace App\IM\Models;

use App\IM\Traits\AllTrait;
use App\Shared\Models\Model as SharedModel;

class Model extends SharedModel {
	protected $connection = 'im';
	/**
	 * Traits
	 */
	use AllTrait;
}
