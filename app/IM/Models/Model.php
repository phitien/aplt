<?php

namespace App\IM\Models;

use Illuminate\Database\Eloquent\Model as CoreModel;
use App\IM\Traits\EncoderTrait;
use App\IM\Traits\UtilTrait;

class Model extends CoreModel implements IModel {
	/**
	 * Traits
	 */
	use UtilTrait, EncoderTrait;
}
