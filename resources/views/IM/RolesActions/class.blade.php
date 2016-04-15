@extends('IM.class_template')

@section('functions')
	/**
	 *
	 * @param string $role        	
	 * @return array
	 */
	public static function getActions($role) {
		return isset ( static::$maps [$role] ) ? static::$maps [$role] : [ ];
	}
	/**
	 *
	 * @param string $role        	
	 * @return string
	 */
	public static function getStringActions($role) {
		return implode ( '|', static::getActions ( $role ) );
	}
	/**
	 *
	 * @param string $role        	
	 * @param string $action        	
	 * @return bool
	 */
	public static function hasAction($role, $action) {
		return in_array ( $action, static::getActions ( $role ) );
	}
	
@endsection