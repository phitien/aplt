<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePricesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'prices', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->unsigned ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'items' )->onDelete ( 'cascade' );
			//
			$table->string ( 'title' )->unique ();
			$table->text ( 'description' )->nullable ();
			//
			$table->string ( 'group' )->nullable ();
			$table->string ( 'group2' )->nullable ();
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
		Schema::table ( 'prices', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
		} );
		Schema::dropIfExists ( 'prices' );
	}
}
    	