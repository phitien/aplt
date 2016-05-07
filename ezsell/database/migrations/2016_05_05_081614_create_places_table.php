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
		// Schema::create ( 'places', function (Blueprint $table) {
		// $table->increments ( 'id' );
		// $table->integer ( 'parent_id' )->unsigned ()->nullable ();
		// $table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'places' )->onDelete ( 'cascade' );
		// $table->integer ( 'level' );
		// $table->boolean ( 'active' )->nullable ()->default ( 0 );
		// //
		// $table->integer ( 'geonameId' );
		// $table->integer ( 'childrenCount' );
		// $table->string ( 'name' );
		// $table->string ( 'toponymName' );
		// $table->string ( 'countryCode' );
		// $table->string ( 'fcode' );
		// //
		// $table->text ( 'options' )->nullable ();
		// //
		// $table->timestamps ();
		// $table->softDeletes ();
		// //
		// $table->index ( [
		// 'fcode',
		// 'countryCode'
		// ], 'place_search_index' );
		// } );
		// //
		// // DB::statement ( 'ALTER TABLE places ADD FULLTEXT INDEX place_fulltext_index (name)' );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// // DB::statement ( 'ALTER TABLE places DROP INDEX place_fulltext_index' );
		// Schema::table ( 'places', function (Blueprint $table) {
		// $table->dropForeign ( [
		// 'parent_id'
		// ] );
		// $table->dropIndex ( 'place_search_index' );
		// } );
		// Schema::dropIfExists ( 'places' );
	}
}
