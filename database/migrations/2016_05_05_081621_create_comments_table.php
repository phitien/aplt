<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCommentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'app' )->hasTable ( 'comments' ))
			Schema::connection ( 'app' )->create ( 'comments', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->integer ( 'item_id' )->unsigned ();
				$table->foreign ( 'item_id' )->references ( 'id' )->on ( 'items' )->onDelete ( 'cascade' );
				$table->integer ( 'parent_id' )->unsigned ();
				$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'comments' )->onDelete ( 'cascade' );
				//
				$table->integer ( 'user_id' );
				//
				$table->text ( 'text' )->nullable ();
				//
				$table->text ( 'options' )->nullable ();
				//
				$table->timestamps ();
				$table->softDeletes ();
				
				$table->unique ( [ 
						'parent_id',
						'user_id',
						'item_id' 
				] );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Schema::connection ( 'app' )->table ( 'comments', function (Blueprint $table) {
		// try {
		// $table->dropForeign ( [
		// 'parent_id'
		// ] );
		// $table->dropForeign ( [
		// 'item_id'
		// ] );
		// } catch ( Exception $e ) {
		// }
		// } );
		// Schema::connection ( 'app' )->dropIfExists ( 'comments' );
	}
}