<?php

namespace App\Shared\View\Html\Menu;

use App\Shared\View\Html\Dom\ul;
use App\Shared\View\Html\Dom\IElement;

class Menu extends ul {
	protected function insertChild(IElement $child, bool $buildChildrenHtml = true) {
		if ($child instanceof MenuItem) {
			return parent::insertChild ( $child, $buildChildrenHtml );
		}
		return $this;
	}
}
