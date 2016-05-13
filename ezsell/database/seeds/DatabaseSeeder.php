<?php
ini_set ( 'memory_limit', '-1' );
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// $this->call ( PlacesTableSeeder::class );
		$this->call ( LocationsTableSeeder::class );
		$this->call ( CatsTableSeeder::class );
	}
}
