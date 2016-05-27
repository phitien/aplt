<?php

namespace App\Platform\Response;

use App\Platform\Helper;
use App\Platform\Config;
use App\Platform\Models\Cat;

class PageResponseData implements \ArrayAccess {
	public function offsetExists($key) {
		return $this->__isset ( $key );
	}
	public function offsetGet($key) {
		return $this->__get ( $key );
	}
	public function offsetSet($key, $value) {
		$this->__set ( $key, $value );
	}
	public function offsetUnset($key) {
		$this->__unset ( $this->_data ['configurations'] [$key] );
	}
	protected $_data = [ 
			'configurations' => [ ] 
	];
	protected $_required = [ 
			'type',
			'title',
			'keywords',
			'description',
			'data',
			'showBanner',
			'showLeft',
			'showRight',
			'theme',
			'user',
			'isGuest',
			'usecode',
			'MODES',
			'mode',
			'mediaBaseUrl',
			'noavatarman',
			'noavatarwoman',
			'cats',
			'location',
			'appMessage',
			'socketUri',
			'linkDirectly' 
	];
	/**
	 * Constructor
	 */
	public function __construct($type) {
		$user = Helper::getUser ();
		$this->_data ['configurations'] = [ 
				'type' => $type,
				'title' => 'Ezsell',
				'keywords' => 'Ezsell',
				'description' => 'Ezsell',
				'data' => null,
				'showBanner' => true,
				'showLeft' => 2,
				'showRight' => 0,
				'theme' => 'south-street',
				'localization' => trans ( 'messages.words' ),
				'user' => base64_encode ( ( string ) $user ),
				'isGuest' => $user->isGuest (),
				'usecode' => Config::USE_CODE,
				'MODES' => Config::$modes,
				'mode' => ( int ) Helper::getMode (),
				'mediaBaseUrl' => Config::MEDIA_BASE_URL,
				'noavatarman' => Config::MEDIA_BASE_URL . "/noavatarman",
				'noavatarwoman' => Config::MEDIA_BASE_URL . "/noavatarwoman",
				'cats' => Cat::getHierarchy (),
				'location' => Helper::getLocation (),
				'appMessage' => '',
				'socketUri' => Config::SOCKET_SERVER_URL,
				'linkDirectly' => false 
		];
	}
	public function __get($key) {
		return $this->_data ['configurations'] [$key];
	}
	public function __set($key, $value) {
		$this->_data ['configurations'] [$key] = $value;
	}
	public function __isset($key) {
		return property_exists ( ( object ) $this->_data ['configurations'], $key );
	}
	public function __unset($key) {
		unset ( $this->_data ['configurations'] [$key] );
	}
	public function setType($value) {
		$this->type = $value;
		return $this;
	}
	public function setTitle($value) {
		$this->title = $value;
		return $this;
	}
	public function setKeywords($value) {
		$this->keywords = $value;
		return $this;
	}
	public function setDescription($value) {
		$this->description = $value;
		return $this;
	}
	public function setData($value) {
		$this->data = $value;
		return $this;
	}
	public function setShowBanner($value) {
		$this->showBanner = ( bool ) $value;
		return $this;
	}
	public function setShowLeft($value) {
		$this->showLeft = ( int ) $value;
		return $this;
	}
	public function setShowRight($value) {
		$this->showRight = ( int ) $value;
		return $this;
	}
	public function setTheme($value) {
		$this->theme = $value;
		return $this;
	}
	public function setAppMessage($value) {
		$this->appMessage = $value;
		return $this;
	}
	public function checkRequired() {
		foreach ( $this->_required as $key ) {
			if (! isset ( $this->{$key} ))
				throw new \Exception ( "Response data requires key '{$key}'" );
		}
	}
	public function __toString() {
		$this->checkRequired ();
		return json_encode ( $this->_data );
	}
	public function getData() {
		$this->checkRequired ();
		return $this->_data;
	}
}