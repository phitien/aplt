<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserGroupTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'user_group', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'user_id' )->unsigned ();
			$table->foreign ( 'user_id' )->references ( 'id' )->on ( 'users' )->onDelete ( 'cascade' );
			$table->integer ( 'group_id' )->unsigned ();
			$table->foreign ( 'group_id' )->references ( 'id' )->on ( 'groups' )->onDelete ( 'cascade' );
			$table->boolean ( 'active' );
			$table->unique ( [ 
					'user_id',
					'group_id' 
			], 'user_group_unique' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'user_group' );
	}
}
