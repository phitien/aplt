<?php
ini_set ( 'memory_limit', '-1' );
use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Schema::table ( 'likes', function (Blueprint $table) {
			$table->unique ( [
					'parent_id',
					'user_id'
			] );
		} );
		Schema::table ( 'comments', function (Blueprint $table) {
			$table->integer ( 'user_id' );
			$table->unique ( [ 
					'parent_id',
					'user_id',
					'item_id' 
			] );
		} );
		// $this->call ( PlacesTableSeeder::class );
		// $this->call ( LocationsTableSeeder::class );
		// $this->call ( CatsTableSeeder::class );
	}
}
