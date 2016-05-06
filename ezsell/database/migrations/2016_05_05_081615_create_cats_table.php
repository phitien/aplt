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
			$table->integer ( 'parent_id' )->unsigned ()->nullable ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'cats' );
			//
			$table->integer ( 'place_id' )->unsigned ();
			$table->foreign ( 'place_id' )->references ( 'id' )->on ( 'places' )->onDelete ( 'cascade' );
			//
			$table->boolean ( 'active' )->nullable ()->default ( 0 );
			//
			$table->string ( 'title' )->unique ();
			$table->text ( 'description' )->nullable ();
			$table->text ( 'avatar' )->nullable ();
			$table->text ( 'cover' )->nullable ();
			//
			$table->text ( 'tags' )->nullable ();
			$table->text ( 'options' )->nullable ();
			//
			$table->integer ( 'bits' )->nullable ()->default ( 0 );
			//
			$table->timestamps ();
			$table->softDeletes ();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table ( 'cats', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
			$table->dropForeign ( [ 
					'place_id' 
			] );
		} );
		Schema::dropIfExists ( 'cats' );
	}
}
