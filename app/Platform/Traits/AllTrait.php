<?php

namespace App\Platform\Traits;

use App\Shared\Traits\ApiCallRestfulTrait;
use App\Shared\Traits\UtilTrait;

trait AllTrait {
	use ApiCallRestfulTrait, 
		LocationTrait, 
		MailerTrait, 
		RequestTimeTrait, 
		ResponseTrait, 
		SessionTrait, 
		ModeTrait,
		UtilTrait;
	
	/**
	 * Build App\Platform\Locations class
	 *
	 * @return void
	 */
	protected static function buildLocationMap() {
		$className = 'LocationMap';
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
	protected static function renderTrait($filePath, $data = []) {
		$data = array_merge ( [ 
				'php' => '<?php' 
		], $data );
		$contents = Html::decode ( View::create ( 'classgenerator.locationmap.trait', $data )->render () );
		Storage::disk ( 'app' )->put ( "{$filePath}.php", $contents );
	}
	protected static function renderClass($filePath, $data = []) {
		$data = array_merge ( [ 
				'php' => '<?php' 
		], $data );
		$contents = Html::decode ( View::create ( 'classgenerator.locationmap.class', $data )->render () );
		Storage::disk ( 'app' )->put ( "{$filePath}.php", $contents );
	}
}
