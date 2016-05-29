<?php

namespace App\Media\Traits;

use App\Shared\Traits\ApiCallRestfulTrait;
use App\Shared\Traits\UtilTrait;

trait AllTrait
{
	use ApiCallRestfulTrait,
		ResponseTrait,
		UserTrait,
		UtilTrait;
}
