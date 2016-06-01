<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserRoleTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'im' )->hasTable ( 'user_role' ))
			Schema::connection ( 'im' )->create ( 'user_role', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->integer ( 'user_id' )->unsigned ();
				$table->foreign ( 'user_id' )->references ( 'id' )->on ( 'users' )->onDelete ( 'cascade' );
				$table->integer ( 'role_id' )->unsigned ();
				$table->foreign ( 'role_id' )->references ( 'id' )->on ( 'roles' )->onDelete ( 'cascade' );
				$table->unique ( [ 
						'user_id',
						'role_id' 
				], 'user_role_unique' );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
// 		if (Schema::connection ( 'im' )->hasTable ( 'user_role' ))
// 			Schema::connection ( 'im' )->dropIfExists ( 'user_role' );
	}
}
	