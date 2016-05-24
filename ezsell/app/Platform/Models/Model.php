<?php

namespace App\Platform\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\Platform\Traits\AllTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use AllTrait;
}
