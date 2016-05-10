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
		Schema::create ( 'comments', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'item_id' )->unsigned ();
			$table->foreign ( 'item_id' )->references ( 'id' )->on ( 'items' )->onDelete ( 'cascade' );
			$table->integer ( 'parent_id' )->unsigned ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'comments' )->onDelete ( 'cascade' );
			//
			$table->text ( 'text' )->nullable ();
			//
			$table->text ( 'options' )->nullable ();
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
		Schema::table ( 'comments', function (Blueprint $table) {
			try {
				$table->dropForeign ( [ 
						'parent_id' 
				] );
				$table->dropForeign ( [ 
						'item_id' 
				] );
			} catch ( Exception $e ) {
			}
		} );
		Schema::dropIfExists ( 'comments' );
	}
}