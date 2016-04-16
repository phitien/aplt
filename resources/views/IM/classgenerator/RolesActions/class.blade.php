@extends('IM.classgenerator.template')

@section('functions')
	/**
	 *
	 * @param string $role        	
	 * @return array
	 */
	public static function getActions($role) {
		return isset ( static::MAPS [$role] ) ? static::MAPS [$role] : [ ];
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