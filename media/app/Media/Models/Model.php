<?php

namespace App\Media\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\Media\Traits\UtilTrait;
use App\Media\Traits\LocationTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use UtilTrait, LocationTrait;
}
