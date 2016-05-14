<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\IM\Traits\AllTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use AllTrait;
}
