<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateGroupRoleTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'group_role', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'group_id' )->unsigned ();
			$table->foreign ( 'group_id' )->references ( 'id' )->on ( 'groups' )->onDelete ( 'cascade' );
			$table->integer ( 'role_id' )->unsigned ();
			$table->foreign ( 'role_id' )->references ( 'id' )->on ( 'roles' )->onDelete ( 'cascade' );
			$table->unique ( [ 
					'group_id',
					'role_id' 
			], 'group_role_unique' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'group_role' );
	}
}
