<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserFollowerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'user_follower', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'user_id' )->unsigned ();
			$table->foreign ( 'user_id' )->references ( 'id' )->on ( 'users' )->onDelete ( 'cascade' );
			$table->integer ( 'follower_id' )->unsigned ();
			$table->foreign ( 'follower_id' )->references ( 'id' )->on ( 'users' )->onDelete ( 'cascade' );
			$table->boolean ( 'active' );
			$table->unique ( [ 
					'user_id',
					'follower_id' 
			], 'user_follower_unique' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'user_follower' );
	}
}
