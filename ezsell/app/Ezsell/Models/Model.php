<?php

namespace App\Ezsell\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\Ezsell\Traits\AllTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use AllTrait;
}
