<?php

namespace App\Ezsell\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\Ezsell\Traits\UtilTrait;
use App\Ezsell\Traits\LocationTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use UtilTrait, LocationTrait;
}
