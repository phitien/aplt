<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateImagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'images', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->unsigned ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'items' )->onDelete ( 'cascade' );
			//
			$table->string ( 'title' )->nullable ();
			$table->text ( 'description' )->nullable ();
			//
			$table->string ( 'url' )->unique ()->nullable ();
			$table->text ( 'options' )->nullable ();
			$table->timestamps ();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table ( 'images', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
		} );
		Schema::dropIfExists ( 'images' );
	}
}
