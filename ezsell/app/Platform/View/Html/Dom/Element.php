<?php

namespace App\Platform\View\Html\Dom;

use App\Platform\View\Html\Dom\Attribute\Attribute;
use App\Platform\View\Html\Dom\Attribute\IAttribute;

class Element implements IElement {
	protected $_id = '';
	protected $_tagName = 'text';
	protected $_attributes = [ ];
	protected $_innerHtml = '';
	protected $_children = [ ];
	protected $_noContent = false;
	public function __construct(array $attributes = [], array $children = []) {
		$this->_id = uniqid ( 'auto_' );
		$this->setAttributes ( $attributes );
		$this->setChildren ( $children );
	}
	public function render() {
		if ($this->isNoContent ())
			return "<{$this->getTagName()} {$this->getAttributesText()} />";
		else
			return "<{$this->getTagName()} {$this->getAttributesText()}>{$this->getInnerHtml ()}</{$this->getTagName()}>";
	}
	public function __get(string $name) {
		return $this->getAttribute ( $name );
	}
	public function __set(string $name, string $value) {
		$this->setAttribute ( $name, $value );
	}
	public function isNoContent() {
		return $this->_noContent;
	}
	public function setNoContent(bool $noContent) {
		$this->_noContent = $noContent;
		return $this;
	}
	public function getAttributes() {
		return $this->_attributes;
	}
	public function setAttributes(array $attributes) {
		foreach ( $this->_attributes as $name => $value ) {
			$this->setAttribute ( $name, $value );
		}
		return $this;
	}
	public function getAttribute(string $nameOrValue) {
		foreach ( $this->_attributes as $i => $attribute ) {
			if (strtolower ( $nameOrValue ) == $attribute->getName ())
				return $attribute;
		}
		foreach ( $this->_attributes as $i => $attribute ) {
			if ($nameOrValue == $attribute->getValue ())
				return $attribute;
		}
		return null;
	}
	public function setAttribute(string $name, string $value) {
		if ($name != 'id')
			array_push ( $this->_attributes, new Attribute ( is_int ( $name ) ? '' : $name, $value ) );
		return $this;
	}
	public function addAttribute(IAttribute $attribute) {
		if ($attribute->getName () != 'id')
			array_push ( $this->_attributes, $attribute );
		return $this;
	}
	public function removeAttribute(string $nameOrValue) {
		foreach ( $this->_attributes as $i => $attribute ) {
			if (strtolower ( $nameOrValue ) == $attribute->getName ()) {
				unset ( $this->_attributes [$i] );
				// array_slice ( $this->_attributes, $i, 1 );
				return $this;
			}
		}
		foreach ( $this->_attributes as $i => $attribute ) {
			if ($nameOrValue == $attribute->getValue ()) {
				unset ( $this->_attributes [$i] );
				// array_slice ( $this->_attributes, $i, 1 );
				return $this;
			}
		}
		return $this;
	}
	protected function getAttributesText() {
		$pieces = [ ];
		if (! $this->isNoContent ())
			array_push ( $pieces, "id='{$this->getId()}'" );
		if ($attributes = $this->getAttributes ())
			foreach ( $attributes as $i => $attribute )
				array_push ( $pieces, ( string ) $attribute );
		return implode ( ' ', $pieces );
	}
	public function __toString() {
		return $this->toHtml ();
	}
	public function toHtml() {
		return $this->render ();
	}
	public function getId() {
		return $this->_id;
	}
	public function setId(string $id) {
		$this->_id = $id;
		return $this;
	}
	public function getTagName() {
		return strtolower ( $this->_tagName );
	}
	public function setTagName(string $tagName) {
		$this->_tagName = $tagName;
		return $this;
	}
	public function getInnerHtml() {
		if (! $this->_innerHtml)
			$this->renderInnerHtml ();
		return $this->_innerHtml;
	}
	public function setInnerHtml(string $html) {
		$this->_innerHtml = $html;
		return $this;
	}
	public function setChildren(array $children) {
		if (! $this->isNoContent ())
			foreach ( $children as $child ) {
				$this->insertChild ( $child, false );
			}
		return $this;
	}
	public function removeAllChildren() {
		$this->_children = [ ];
		return $this;
	}
	protected function renderInnerHtml() {
		if ($children = $this->getChildren ()) {
			$pieces = [ ];
			foreach ( $children as $child ) {
				array_push ( $pieces, $child->toHtml () );
			}
			$this->_innerHtml = implode ( '', $pieces );
		} else {
			$this->_innerHtml = '';
		}
	}
	public function getChildren() {
		return $this->_children;
	}
	public function addChild(IElement $child) {
		return $this->insertChild ( $child, true );
	}
	protected function insertChild(IElement $child, bool $buildChildrenHtml = true) {
		array_push ( $this->_children, $child );
		return $this;
	}
	public function removeChild(string $id) {
		if ($this->_children) {
			foreach ( $this->_children as $i => $child ) {
				if ($id == $child->getId ()) {
					array_splice ( $this->_children, $i, 1 );
					break;
				}
			}
		}
		return $this;
	}
}
