<?php

namespace App\Platform;

use App\Platform\Traits\AllTrait;
use App\Shared\Helper as BaseHelper;

class Helper extends BaseHelper {
	use AllTrait;
	/**
	 *
	 * @var string
	 */
	public static $_location_id;
	/**
	 *
	 * @var array
	 */
	public static $_location;
	/**
	 *
	 * @var string
	 */
	public static $_request_time;
	/**
	 *
	 * @var string
	 */
	public static $_mode;
	/**
	 *
	 * @var \App\Shared\Models\User
	 */
	public static $_user;
}
