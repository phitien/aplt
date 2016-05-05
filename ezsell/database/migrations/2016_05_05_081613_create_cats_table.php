<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCatsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'cats', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->unsigned ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'cats' )->onDelete ( 'cascade' );
			$table->string ( 'title' )->unique ();
			$table->string ( 'description' )->unique ();
			$table->string ( 'avatar' )->nullable ();
			$table->string ( 'cover' )->nullable ();
			$table->string ( 'country' )->nullable ();
			$table->string ( 'state' )->nullable ();
			$table->string ( 'city' )->nullable ();
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
		Schema::dropIfExists ( 'cats' );
	}
}
