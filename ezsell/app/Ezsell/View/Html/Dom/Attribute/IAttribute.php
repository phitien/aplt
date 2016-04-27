<?php

namespace App\Ezsell\View\Html\Dom\Attribute;

interface IAttribute {
	public function getName();
	public function setName(string $name);
	public function getValue();
	public function setValue(string $value);
}
