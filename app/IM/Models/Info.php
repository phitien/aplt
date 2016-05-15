<?php

namespace App\IM\Models;

class Info extends User {
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Illuminate\Database\Eloquent\Model::toArray()
	 */
	public function toArray() {
		$fields = [ 
				'id',
				'name',
				'first_name',
				'last_name',
				'middle_name',
				'alias',
				'birthday',
				'gender',
				'marital_status',
				'mobile',
				'country',
				'state',
				'city',
				'address',
				'postcode',
				'avatar',
				'cover',
				'status',
				'quote',
				'description' 
		];
		$attributes = $this->attributesToArray ();
		$rs ['displayname'] = $this->getDisplayName ();
		foreach ( $fields as $field ) {
			if (isset ( $attributes [$field] ))
				$rs [$field] = $attributes [$field];
		}
		
		return $rs;
	}
	/**
	 * Override all methods to avoid using this object to modify user;
	 */
	public static function create(array $attributes = []) {
		return false;
	}
	public static function decodeActivationCode($activationCode) {
		return false;
	}
	public function activate($activationCode) {
		return false;
	}
	public function deactivate() {
		return false;
	}
	protected function activationLinkExpired($activationCode) {
	}
	public function save(array $options = []) {
		return false;
	}
	public function fill(array $attributes) {
		return false;
	}
	public function changeEmail($email) {
		return false;
	}
	public function changePassword($password) {
		return false;
	}
	public function changeName($name) {
		return false;
	}
}
