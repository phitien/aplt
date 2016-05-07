<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Ezsell\Models\Place;
class PlacesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard ();
		// clone places info from http://www.geonames.org/childrenJSON?geonameId=6295630
		// $world = new Place ();
		// $world->level = 0;
		// $world->active = true;
		// $world->geonameId = 6295630;
		// $world->name = 'Earth';
		// $world->toponymName = 'Earth';
		// $world->save ();
		// $world->takeMyChildren ( 1 );
		// //
		// $current = Place::find ( 2 );
		// $current->takeMyChildren ( 3 );
		// //
		// $current = Place::find ( 3 );
		// $current->takeMyChildren ( 3 );
		//
		// $current = Place::find ( 4 );
		// $current->takeMyChildren ( 3 );
		// //
		// $current = Place::find ( 5 );
		// $current->takeMyChildren ( 3 );
		// //
		// $current = Place::find ( 6 );
		// $current->takeMyChildren ( 3 );
		// //
		// $current = Place::find ( 7 );
		// $current->takeMyChildren ( 3 );
		// //
		// $current = Place::find ( 8 );
		// $current->takeMyChildren ( 3 );
		//
		Model::reguard ();
	}
}
