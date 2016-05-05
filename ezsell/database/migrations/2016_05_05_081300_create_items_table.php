<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'items', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'user_id' )->unsigned ();
			$table->string ( 'title' )->unique ();
			$table->string ( 'content' )->unique ();
			$table->text ( 'tags' )->nullable ();
			$table->text ( 'json' )->nullable ();
			$table->integer ( 'index' )->nullable ();
			$table->integer ( 'bits' )->nullable ()->default ( 0 );
			$table->timestamps ();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'items' );
	}
}
