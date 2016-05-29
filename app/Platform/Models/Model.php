<?php

namespace App\Platform\Models;

use App\Platform\Traits\AllTrait;
use App\Shared\Models\Model as BaseModel;

class Model extends BaseModel {
	protected $connection = 'app';
	/**
	 * Traits
	 */
	use AllTrait;
}
