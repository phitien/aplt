<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateLikesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'app' )->hasTable ( 'likes' ))
			Schema::connection ( 'app' )->create ( 'likes', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->integer ( 'parent_id' )->unsigned ();
				$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'items' )->onDelete ( 'cascade' );
				//
				$table->integer ( 'user_id' );
				//
				$table->text ( 'options' )->nullable ();
				//
				$table->timestamps ();
				$table->softDeletes ();
				
				$table->unique ( [ 
						'parent_id',
						'user_id' 
				] );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Schema::connection ( 'app' )->table ( 'likes', function (Blueprint $table) {
		// $table->dropForeign ( [
		// 'parent_id'
		// ] );
		// } );
		// Schema::connection ( 'app' )->dropIfExists ( 'likes' );
	}
}
