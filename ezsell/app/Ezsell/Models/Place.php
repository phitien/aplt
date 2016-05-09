<?php

namespace App\Ezsell\Models;

use GuzzleHttp\Client;

class Place extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'parent_id',
			'level',
			'active',
			'geonameId',
			'childrenCount',
			'name',
			'toponymName',
			'countryCode',
			'fcode',
			'options' 
	];
	protected $hidden = [ ];
	protected $dates = [ 
			'created_at',
			'updated_at',
			'deleted_at' 
	];
	protected $casts = [ 
			'active' => 'boolean',
			'options' => 'array' 
	];
	public static function getCountry($countryCode) {
		return static::where ( 'countryCode', $countryCode )->first ();
	}
	public static function getStates($countryCode) {
		return static::where ( 'countryCode', $countryCode )->where ( 'level', 2 )->get ();
	}
	public static function getCounties($stateId) {
		return static::where ( 'parent_id', $stateId )->get ();
	}
	public static function getCounty($countyId) {
		return static::find ( $countyId );
	}
	public function location() {
		return $this->hasOne ( 'App\Ezsell\Models\Location', 'id', 'id' );
	}
	public function parent() {
		return $this->belongsTo ( 'App\Ezsell\Models\Place', 'parent_id', 'id' );
	}
	public function children() {
		return $this->hasMany ( 'App\Ezsell\Models\Place', 'id', 'parent_id' );
	}
	public function takeMyChildren($level, $startId = null) {
		try {
			if ($this->level < $level) {
				echo "CLONE::$this->geonameId - $this->fcode - $this->name - $this->countryCode\n";
				$client = new Client ();
				$response = $client->get ( "http://www.geonames.org/childrenJSON?geonameId={$this->geonameId}" );
				$json = json_decode ( $response->getBody () );
				if ($json) {
					if (isset ( $json->totalResultsCount )) {
						$this->childrenCount = $json->totalResultsCount;
						$this->save ();
					}
					if (isset ( $json->geonames )) {
						$start = $startId ? false : true;
						foreach ( $json->geonames as $item ) {
							if (! $start) {
								$start = $item->geonameId == $startId;
								continue;
							}
							$place = new Place ();
							$place->parent_id = $this->id;
							$place->level = $this->level + 1;
							$place->active = true;
							$place->geonameId = $item->geonameId;
							$place->name = $item->name;
							$place->toponymName = $item->toponymName;
							if (isset ( $item->countryCode ))
								$place->countryCode = $item->countryCode;
							$place->fcode = $item->fcode;
							$place->options = ( array ) $item;
							$place->save ();
							echo "SAVE::$place->geonameId - $place->fcode - $place->name - $place->countryCode\n";
						}
						$places = static::where ( 'parent_id', $this->id )->get ();
						foreach ( $places as $place ) {
							$place->takeMyChildren ( $level );
						}
					}
				}
			}
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
}
