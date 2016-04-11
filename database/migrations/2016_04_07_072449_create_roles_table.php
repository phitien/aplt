<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateRolesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'roles', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->string ( 'code' )->unique ();
			$table->string ( 'description' );
			$table->boolean ( 'active' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'roles' );
	}
}
