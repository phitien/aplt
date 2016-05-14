<?php

namespace App\Media\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\Media\Traits\AllTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use AllTrait;
}
