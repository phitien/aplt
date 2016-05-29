<?php

namespace App\Shared\View\Html\Dom\Attribute;

class Attribute implements IAttribute {
	protected $_name = '';
	protected $_value = '';
	public function __construct(string $name = '', string $value = '') {
		$this->_name = $name;
		$this->_value = $value;
	}
	public function getName() {
		return strtolower ( $this->_name );
	}
	public function setName(string $name) {
		$this->_name = $name;
		return $this;
	}
	public function getValue() {
		return $this->_value;
	}
	public function setValue(string $value) {
		$this->_value = $value;
		return $this;
	}
	public function __toString() {
		if ($this->_name && $this->_value)
			return "{$this->getName()}='{$this->getValue()}'";
		else if ($this->_value)
			return "{$this->getValue()}";
		else
			return '';
	}
}
