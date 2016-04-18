<?php

namespace App\Ezsell\Models\User;

use stdClass;

class UserExtension {
	/**
	 *
	 * @var \stdClass
	 */
	protected $_data;
	/**
	 *
	 * @param string $json        	
	 */
	public function __construct($json) {
		if ($json && $data = json_decode ( $json )) {
			$this->_data = $data;
		} else {
			$this->_data = new stdClass ();
		}
	}
	/**
	 *
	 * @return \stdClass
	 */
	public function all() {
		return $this->_data;
	}
	/**
	 *
	 * @param unknown $key        	
	 */
	public function __get($key) {
		if (property_exists ( $this->_data, $key )) {
			return $this->_data->$key;
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
		$this->_data->$key = $value;
	}
	/**
	 *
	 * @return string
	 */
	public function toJson() {
		return json_encode ( $this->_data );
	}
	/**
	 *
	 * @param array $attributes        	
	 */
	public function fill(array $attributes) {
		foreach ( $this->_data as $key => $val ) {
			unset ( $this->_data->$key );
		}
		foreach ( $attributes as $key => $val ) {
			$this->_data->$key = $val;
		}
	}
}