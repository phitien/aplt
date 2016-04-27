<?php

namespace App\Ezsell\View\Html\Menu;

use App\Ezsell\View\Html\Dom\li;
use App\Ezsell\View\Html\Dom\a;
use App\Ezsell\View\Html\Dom\span;

class MenuItem extends li {
	protected $_text = '';
	protected $_href = '';
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
		return $this;
	}
	public function getChildren() {
		return array_merge ( [ 
				(new a ())->setHref ( $this->_href )->addChild ( (new span ())->setInnerHtml ( $this->_text ) ) 
		], parent::getChildren () );
	}
}
