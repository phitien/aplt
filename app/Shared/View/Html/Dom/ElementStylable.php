<?php

namespace App\Shared\View\Html\Dom;

class ElementStylable extends Element implements IElementStylable {
	protected $_styles = [ ];
	protected $_className = '';
	public function __construct(array $attributes = [], array $children = [], array $styles = []) {
		parent::__construct ( $attributes, $children );
		$this->setStyles ( $styles );
	}
	public function getStyles() {
		$pieces = [ ];
		if ($this->_styles)
			foreach ( $this->_styles as $name => $value )
				array_push ( $pieces, "{$name}:{$value}" );
		return implode ( ';', $pieces );
	}
	public function setStyles($styles) {
		$this->_styles = $styles;
		return $this;
	}
	public function getStyle(string $name) {
		return $this->_styles [$name];
	}
	public function setStyle(string $name, string $value) {
		if (is_int ( $name ))
			array_push ( $this->_styles, $value );
		else
			$this->_styles [$name] = $value;
		return $this;
	}
	public function removeStyle(string $nameOrValue) {
		if ($this->_styles) {
			foreach ( $this->_styles as $name => $value ) {
				if ($name == $nameOrValue) {
					unset ( $this->_styles [$name] );
					return $this;
				}
			}
			foreach ( $this->_styles as $name => $value ) {
				if ($value == $nameOrValue) {
					unset ( $this->_styles [$name] );
					return $this;
				}
				$i ++;
			}
		}
		return $this;
	}
	public function getClassName() {
		return $this->_className;
	}
	public function setClassName(string $value) {
		$this->_className = $value;
		return $this;
	}
	public function getAttributes() {
		$this->removeAttribute ( 'class' );
		$this->removeAttribute ( 'style' );
		$this->setAttribute ( 'class', $this->getClassName () );
		$this->setAttribute ( 'style', $this->getStyles () );
		return parent::getAttributes ();
	}
}
