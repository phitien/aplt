<?php

namespace App\Ezsell;

use App\Ezsell\Traits\AllTrait;

class Helper {
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
	 * @var string $_userInfoFromRequest
	 */
	public static $_userInfoFromRequest;
	/**
	 *
	 * @var \App\User
	 */
	public static $_user;
	/**
	 *
	 * @var string
	 */
	public static $_token;
}
