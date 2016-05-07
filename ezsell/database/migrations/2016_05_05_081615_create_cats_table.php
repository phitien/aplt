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
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'cats' )->onDelete ( 'cascade' );
			//
			$table->string ( 'code' )->unique ();
			$table->boolean ( 'active' )->nullable ()->default ( 0 );
			//
			$table->integer ( 'order' )->unsigned ();
			//
			$table->timestamps ();
			$table->softDeletes ();
			//
			$table->index ( [ 
					'code' 
			], 'cat_search_index' );
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
			$table->dropIndex ( 'cat_search_index' );
		} );
		Schema::dropIfExists ( 'cats' );
	}
}
