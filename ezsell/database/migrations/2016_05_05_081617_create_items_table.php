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
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table ( 'items', function (Blueprint $table) {
			$table->dropForeign ( [ 
					'parent_id' 
			] );
			$table->dropForeign ( [ 
					'place_id' 
			] );
		} );
		Schema::dropIfExists ( 'items' );
	}
}
