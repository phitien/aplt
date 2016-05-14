@extends('classgenerator.class')

@section('namespace')App\IM\Config @endsection

@section('uses')
use App\IM\Config\RolesActionsTrait;
@endsection

@section('name')RolesActions @endsection

@section('traits')
	/**
	 * TRAITS
	 */
	use RolesActionsTrait;
@endsection

@section('functions')
	/**
	 *
	 * @param  string $role        	
	 * @return  array
	 */
	public static function getActions($role) {
		return isset ( static::$__maps [$role] ) ? static::$__maps [$role] : [ ];
	}
	/**
	 *
	 * @param  string $role        	
	 * @return  string
	 */
	public static function getStringActions($role) {
		return implode ( '|', static::getActions ( $role ) );
	}
	/**
	 *
	 * @param  string $role        	
	 * @param  string $action        	
	 * @return  bool
	 */
	public static function hasAction($role, $action) {
		return in_array ( $action, static::getActions ( $role ) );
	}
@endsection