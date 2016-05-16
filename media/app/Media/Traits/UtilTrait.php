<?php

namespace App\Media\Traits;

use App\Media\Models\Location;
use Illuminate\Support\Facades\Storage;
use View;
use Html;

trait UtilTrait {
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function encode($str) {
		return bcrypt ( $str );
	}
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected static function encrypt($string) {
		$data = base64_encode ( $string );
		$data = str_replace ( array (
				'+',
				'/',
				'=' 
		), array (
				'-',
				'_',
				'' 
		), $data );
		return $data;
	}
	
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	protected static function decrypt($string) {
		$data = str_replace ( array (
				'-',
				'_' 
		), array (
				'+',
				'/' 
		), $string );
		$mod4 = strlen ( $data ) % 4;
		if ($mod4) {
			$data .= substr ( '====', $mod4 );
		}
		return base64_decode ( $data );
	}
	/**
	 *
	 * @return string
	 */
	protected static function getBaseUri() {
		return (request ()->secure () ? 'https' : 'http') . '://' . request ()->server->get ( 'SERVER_NAME' );
	}
	/**
	 *
	 * @return string
	 */
	protected static function getRedirectUri() {
		return request ()->session ()->get ( 'redirect', '/' );
	}
	/**
	 *
	 * @param string $str        	
	 */
	public static function json_decode($json, $assoc = null, $depth = null, $options = null) {
		$json = preg_replace ( '/[\pZ\pC]+|[\pZ\pC]+/u', '', $json );
		return json_decode ( $json, $assoc, $depth, $options );
	}
	/**
	 * Build App\Media\Locations class
	 *
	 * @return void
	 */
	public static function buildLocationMap() {
		$items = [ ];
		$locations = Location::all ();
		foreach ( $locations as $location ) {
			$json = json_decode ( ( string ) $location, true );
			$pairs = [ ];
			foreach ( $json as $k => $v ) {
				$v = addslashes ( $v );
				array_push ( $pairs, "'{$k}'=>'{$v}'" );
			}
			$text = implode ( ',', $pairs );
			if ($location->fcode == 'EARTH')
				$items ["EARTH"] = "[{$text}]";
			else
				$items ["l{$location->id}"] = "[{$text}]";
		}
		$className = 'LocationMap';
		$maps = [ ];
		foreach ( $items as $k => $v ) {
			array_push ( $maps, "'{$k}'=>{$v}\n" );
		}
		$text = implode ( ',', $maps );
		static::renderTrait ( "Config/{$className}Trait", [ 
				'public_static_vars' => [ 
						'maps' => "[{$text}]" 
				] 
		] );
		static::renderClass ( "Config/{$className}" );
	}
	public static function renderTrait($filePath, $data = []) {
		$data = array_merge ( [ 
				'php' => '<?php' 
		], $data );
		$contents = Html::decode ( View::create ( 'classgenerator.locationmap.trait', $data )->render () );
		Storage::disk ( 'media' )->put ( "{$filePath}.php", $contents );
	}
	public static function renderClass($filePath, $data = []) {
		$data = array_merge ( [ 
				'php' => '<?php' 
		], $data );
		$contents = Html::decode ( View::create ( 'classgenerator.locationmap.class', $data )->render () );
		Storage::disk ( 'media' )->put ( "{$filePath}.php", $contents );
	}
}
