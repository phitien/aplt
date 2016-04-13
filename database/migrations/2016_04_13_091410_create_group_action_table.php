<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateGroupActionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'group_action', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'group_id' )->unsigned ();
			$table->foreign ( 'group_id' )->references ( 'id' )->on ( 'groups' )->onDelete ( 'cascade' );
			$table->integer ( 'action_id' )->unsigned ();
			$table->foreign ( 'action_id' )->references ( 'id' )->on ( 'actions' )->onDelete ( 'cascade' );
			$table->unique ( [ 
					'group_id',
					'action_id' 
			], 'group_action_unique' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'group_action' );
	}
}
    	