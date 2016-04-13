<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateGroupsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'groups', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->string ( 'name' )->unique ();
			$table->string ( 'avatar' )->nullable ();
			$table->string ( 'cover' )->nullable ();
			$table->text ( 'status' )->nullable ();
			$table->text ( 'quote' )->nullable ();
			$table->text ( 'description' )->nullable ();
			$table->text ( 'json' )->nullable ();
			$table->boolean ( 'active' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'groups' );
	}
}
