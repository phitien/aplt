<?php

namespace App\IM\Models\User;

use stdClass;

class UserExtension {
	protected $user;
	protected $data;
	public function __construct($json) {
		if ($json && $data = json_decode ( $json )) {
			$this->data = $data;
		} else {
			$this->data = new stdClass ();
		}
	}
	public function all() {
		return $this->data;
	}
	public function __get($key) {
		if (property_exists ( $this->data, $key )) {
			return $this->data->$key;
		} else {
			return null;
		}
	}
	public function __set($key, $value) {
		$this->data->$key = $value;
	}
	public function toJson() {
		return json_encode ( $this->data );
	}
	public function fill($attributes) {
		foreach ( $this->data as $key => $val ) {
			unset ( $this->data->$key );
		}
		foreach ( $attributes as $key => $val ) {
			$this->data->$key = $val;
		}
	}
}