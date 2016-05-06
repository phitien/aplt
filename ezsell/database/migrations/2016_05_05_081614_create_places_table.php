<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePlacesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'places', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->unsigned ()->nullable ();
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'places' )->onDelete ( 'cascade' );
			
			$table->boolean ( 'active' )->nullable ()->default ( 0 );
			//
			$table->integer ( 'geonameId' );
			$table->string ( 'name' );
			$table->string ( 'toponymName' );
			$table->string ( 'countryCode' );
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
		Schema::table ( 'places', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
		} );
		Schema::dropIfExists ( 'places' );
	}
}
