<?php

namespace App\Shared\View\Html\Dom;

class a extends ElementStylable {
	protected $_tagName = 'a';
	protected $_href = '';
	public function getHref() {
		return $this->_href ? $this->_href : '#';
	}
	public function setHref(string $href) {
		$this->_href = $href;
		return $this->setAttribute ( 'href', $this->_href );
	}
}
