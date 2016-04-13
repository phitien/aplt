<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserActionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'user_action', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'user_id' )->unsigned ();
			$table->foreign ( 'user_id' )->references ( 'id' )->on ( 'users' )->onDelete ( 'cascade' );
			$table->integer ( 'action_id' )->unsigned ();
			$table->foreign ( 'action_id' )->references ( 'id' )->on ( 'actions' )->onDelete ( 'cascade' );
			$table->unique ( [ 
					'user_id',
					'action_id' 
			], 'user_action_unique' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'user_action' );
	}
}
    	