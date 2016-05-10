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
		// //Africa (58 children)
		// $current = Place::find ( 2 );
		// $current->takeMyChildren ( 3 );
		// //Antarctica (5 children)
		// $current = Place::find ( 3 );
		// $current->takeMyChildren ( 3 );
		// Asia (52 children)
		// $current = Place::find ( 4 );
		// $current->takeMyChildren ( 3 );
		// //Europe (5 children)
		// $current = Place::find ( 5 );
		// $current->takeMyChildren ( 3 );
		// //North America (5 children)
		// $current = Place::find ( 6 );
		// $current->takeMyChildren ( 3 );
		// //Oceania (5 children)
		// $current = Place::find ( 7 );
		// $current->takeMyChildren ( 3 );
		// //South America (5 children)
		// $current = Place::find ( 8 );
		// $current->takeMyChildren ( 3 );
		
		// // support 1 more level for big countries
		// $big = [
		// 872, // China (31)
		// 877, // India (36)
		// 1911, // Russia (83)
		// 3111, // Canada (13)
		// 3142, // United States (52)
		// 4005, // Australia (8)
		// 4319, // Argentina (24)
		// 4321, // Brazil (27)
		// ];
		
		// foreach ($big as $id) {
		// $current = Place::find ( $id );
		// foreach ( $current->children as $child ) {
		// $child->takeMyChildren ( 4 );
		// }
		// }
		
		// disable searching for small countries
		$small = [ 
				1922, // Vatican City (1)
				1904, // Monaco (1)
				4016, // Nauru (14)
				4020, // Tuvalu (8)
				1912, // San Marino (9)
				1898, // Liechtenstein (11)
				4014, // Marshall Islands (33)
				3133, // Saint Kitts and Nevis (14)
				891, // Maldives (20)
				1902, // Malta (68)
				3120, // Grenada (7)
				3137, // Saint Vincent and the Grenadines (6)
				3106, // Barbados (11)
				3103, // Antigua and Barbuda (8)
				52, // Seychelles (25)
				4022, // Palau (16)
				1875, // Andorra (7)
				3134, // Saint Lucia (11)
				902, // Singapore (5)
				4015, // Micronesia (4)
				4029, // Tonga (5)
				3116, // Dominica (10)
				866, // Bahrain (5)
				4013 
		]; // Kiribati (3)
		
		foreach ( $small as $id ) {
			$current = Place::find ( $id );
			foreach ( $current->children as $child ) {
				$child->active = 0;
				$child->save ();
			}
		}
		
		Model::reguard ();
	}
}
