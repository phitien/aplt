<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCatDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'cat_details', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->unsigned ()->nullable ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'cats' )->onDelete ( 'cascade' );
			//
			$table->integer ( 'place_id' )->unsigned ();
			$table->foreign ( 'place_id' )->references ( 'id' )->on ( 'places' )->onDelete ( 'cascade' );
			//
			$table->boolean ( 'active' )->nullable ()->default ( 0 );
			//
			$table->string ( 'name' )->unique ();
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
			//
			$table->index ( [ 
					'parent_id',
					'place_id',
					'name' 
			], 'cat_detail_search_index' );
		} );
		//
		// DB::statement ( 'ALTER TABLE cat_details ADD FULLTEXT KEY cat_detail_fulltext_index (name,title,description)' );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// DB::statement ( 'ALTER TABLE cat_details DROP INDEX cat_detail_fulltext_index' );
		Schema::table ( 'cat_details', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
			$table->dropForeign ( [ 
					'place_id' 
			] );
			$table->dropIndex ( 'cat_detail_search_index' );
		} );
		Schema::dropIfExists ( 'cat_details' );
	}
}
