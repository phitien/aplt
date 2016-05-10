<?php

namespace App\Ezsell\View\Html\Menu;

use App\Ezsell\View\Html\Dom\li;
use App\Ezsell\View\Html\Dom\a;
use App\Ezsell\View\Html\Dom\span;

class MenuItem extends li {
	protected $_text = '';
	protected $_href = '';
	protected $_link = NULL;
	public function getText() {
		return $this->_text;
	}
	public function setText(string $text) {
		$this->_text = $text;
		return $this;
	}
	public function getHref() {
		return $this->_href;
	}
	public function setHref(string $href) {
		$this->_href = $href;
		$this->_link = (new a ())->setHref ( $this->_href )->addChild ( (new span ())->setInnerHtml ( $this->_text ) );
		return $this;
	}
	public function setAttribute(string $name, string $value) {
		if (strtolower ( $name ) == 'onclick') {
			$this->_link = (new a ())->setHref ( 'javascript:void(0)' )->setAttribute ( 'onClick', $value )->addChild ( (new span ())->setInnerHtml ( $this->_text ) );
			return $this;
		} else {
			return parent::setAttribute ( $name, $value );
		}
	}
	public function getChildren() {
		if ($this->_link) {
			return array_merge ( [ 
					$this->_link 
			], parent::getChildren () );
		} else {
			return array_merge ( [ 
					(new a ())->setHref ( $this->_href )->addChild ( (new span ())->setInnerHtml ( $this->_text ) ) 
			], parent::getChildren () );
		}
	}
}
