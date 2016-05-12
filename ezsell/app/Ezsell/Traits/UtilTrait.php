<?php

namespace App\Ezsell\Traits;

use Illuminate\Support\Facades\Crypt;
use App\Ezsell\Models\Location;
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
	public static function encrypt($str) {
		return Crypt::encrypt ( $str );
	}
	
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function decrypt($str) {
		return Crypt::decrypt ( $str );
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
	 * Build App\Ezsell\Locations class
	 *
	 * @return void
	 */
	public static function buildLocationMap() {
		$items = [ ];
		$locations = Location::all ();
		foreach ( $locations as $location ) {
			$i = json_decode ( ( string ) $location, true );
			$items ["{$location->id}"] = addslashes ( $i ['fullname'] );
		}
		$className = 'LocationMap';
		$maps = [ ];
		foreach ( $items as $k => $v ) {
			array_push ( $maps, "'{$k}'=>'{$v}'\n" );
		}
		$contents = Html::decode ( View::create ( 'classgenerator.locationmap.class', [ 
				'php' => '<?php',
				'namespace' => 'App\Ezsell\Config',
				'classname' => $className,
				'public_static_vars' => [ 
						'maps' => "[" . implode ( ",", $maps ) . "]" 
				] 
		], [ ], true )->render () );
		Storage::disk ( 'ezsell' )->put ( "Config/{$className}.php", $contents );
	}
}
