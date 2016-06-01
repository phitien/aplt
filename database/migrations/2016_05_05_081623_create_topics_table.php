<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTopicsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'app' )->hasTable ( 'topics' ))
			Schema::connection ( 'app' )->create ( 'topics', function (Blueprint $table) {
				$table->increments ( 'id' );
				//
				$table->integer ( 'location_id' )->unsigned ();
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
				//
				$table->index ( [ 
						'location_id',
						'title' 
				], 'group_search_index' );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Schema::connection ( 'app' )->table ( 'topics', function (Blueprint $table) {
		// $table->dropIndex ( 'group_search_index' );
		// } );
		// Schema::connection ( 'app' )->dropIfExists ( 'topics' );
	}
}
