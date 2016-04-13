<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateActionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'actions', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->string ( 'code' )->unique ();
			$table->string ( 'name' );
			$table->text ( 'description' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'actions' );
	}
}
