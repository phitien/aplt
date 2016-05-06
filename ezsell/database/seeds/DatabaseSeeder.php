<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Ezsell\Models\Place;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard ();
		// TODO clone places info from http://www.geonames.org/childrenJSON?geonameId=6295630
		$world = new Place ();
		$world->active = true;
		$world->geonameId = 6295630;
		$world->name = 'Earth';
		$world->toponymName = 'Earth';
		$world->save ();
		Model::reguard ();
	}
}
