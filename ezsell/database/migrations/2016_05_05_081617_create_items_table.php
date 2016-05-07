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
			$table->integer ( 'parent_id' )->unsigned ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'cats' )->onDelete ( 'cascade' );
			//
			$table->integer ( 'place_id' )->unsigned ();
			$table->foreign ( 'place_id' )->references ( 'id' )->on ( 'places' )->onDelete ( 'cascade' );
			//
			$table->boolean ( 'active' )->nullable ()->default ( 0 );
			//
			$table->string ( 'title' )->unique ();
			$table->text ( 'description' )->nullable ();
			//
			$table->boolean ( 'is_selling' )->nullable ()->default ( 1 );
			//
			$table->boolean ( 'is_new' )->nullable ();
			//
			$table->float ( 'originalprice' )->nullable ();
			$table->float ( 'saleprice' )->nullable ();
			$table->float ( 'nowprice' )->nullable ();
			//
			$table->string ( 'meetup_at' )->nullable ();
			$table->string ( 'meetup_details' )->nullable ();
			//
			$table->string ( 'mailing_details' )->nullable ();
			//
			$table->text ( 'groups' )->nullable ();
			//
			$table->text ( 'tags' )->nullable ();
			$table->text ( 'options' )->nullable ();
			$table->integer ( 'bits' )->nullable ()->default ( 0 );
			//
			$table->timestamps ();
			$table->softDeletes ();
			//
			$table->index ( [ 
					'user_id',
					'parent_id',
					'place_id',
					'title' 
			], 'item_search_index' );
		} );
		//
		// DB::statement ( 'ALTER TABLE items ADD FULLTEXT KEY item_fulltext_index (title,description)' );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// DB::statement ( 'ALTER TABLE items DROP INDEX item_fulltext_index' );
		Schema::table ( 'items', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
			$table->dropForeign ( [ 
					'place_id' 
			] );
			$table->dropIndex ( 'item_search_index' );
		} );
		Schema::dropIfExists ( 'items' );
	}
}
