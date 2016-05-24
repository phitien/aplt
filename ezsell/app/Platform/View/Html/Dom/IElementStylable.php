<?php

namespace App\Platform\View\Html\Dom;

interface IElementStylable {
	public function getStyles();
	public function getStyle(string $tagName);
	public function setStyle(string $name, string $value);
	public function removeStyle(string $nameOrValue);
	public function getClassName();
	public function setClassName(string $value);
}
