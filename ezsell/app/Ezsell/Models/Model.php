<?php

namespace App\Ezsell\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\Ezsell\Traits\EncoderTrait;
use App\Ezsell\Traits\UtilTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use UtilTrait, EncoderTrait;
}
