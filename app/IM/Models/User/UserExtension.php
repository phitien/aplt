<?php

namespace App\IM\Models\User;

use stdClass;

class UserExtension {
	/**
	 *
	 * @var \stdClass
	 */
	protected $data;
	/**
	 *
	 * @param string $json        	
	 */
	public function __construct($json) {
		if ($json && $data = json_decode ( $json )) {
			$this->data = $data;
		} else {
			$this->data = new stdClass ();
		}
	}
	/**
	 *
	 * @return \stdClass
	 */
	public function all() {
		return $this->data;
	}
	/**
	 *
	 * @param unknown $key        	
	 */
	public function __get($key) {
		if (property_exists ( $this->data, $key )) {
			return $this->data->$key;
		} else {
			return null;
		}
	}
	/**
	 *
	 * @param string $key        	
	 * @param unknown $value        	
	 */
	public function __set($key, $value) {
		$this->data->$key = $value;
	}
	/**
	 *
	 * @return string
	 */
	public function toJson() {
		return json_encode ( $this->data );
	}
	/**
	 *
	 * @param array $attributes        	
	 */
	public function fill(array $attributes) {
		foreach ( $this->data as $key => $val ) {
			unset ( $this->data->$key );
		}
		foreach ( $attributes as $key => $val ) {
			$this->data->$key = $val;
		}
	}
}