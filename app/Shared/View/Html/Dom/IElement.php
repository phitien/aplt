<?php

namespace App\Shared\View\Html\Dom;

interface IElement {
	public function getId();
	public function setId(string $id);
	public function getTagName();
	public function setTagName(string $tagName);
	public function getAttributes();
	public function setAttribute(string $name, string $value);
	public function removeAttribute(string $name);
	public function setChildren(array $children);
	public function removeAllChildren();
	public function getChildren();
	public function addChild(IElement $child);
	public function removeChild(string $id);
	public function getInnerHtml();
	public function setInnerHtml(string $html);
	public function isNoContent();
	public function setNoContent(bool $noContent);
	public function toHtml();
}
