@extends('classgenerator.template')

@section('functions')
	/**
	 *
	 * @param string $id
	 * @return string
	 */
	public static function getName($id) {
		return isset ( static::$maps [$id] ) ? static::$maps [$id] : '';
	}
	/**
	 *
	 * @param string $id
	 * @return array
	 */
	public static function get($id) {
		return isset ( static::$maps [$id] ) ? [ 
			'id' => $id,
			'name' => static::$maps [$id] 
		] : null;
	}
	/**
	 *
	 * @param string $q
	 * @return array
	 */
	public static function search($q) {
		return array_filter(static::$maps, function($v, $k) use ($q) {
		    return strpos($v, $q) !== false || strpos($k, $q) !== false;
		}, ARRAY_FILTER_USE_BOTH);
	}
@endsection