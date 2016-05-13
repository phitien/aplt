<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateResourcesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'resources', function (Blueprint $table) {
			$table->increments ( 'id' );
			//
			$table->integer ( 'user_id' )->nullable ();
			$table->string ( 'code' );
			$table->text ( 'path' );
			$table->unique ( [ 
					'user_id',
					'code' 
			] );
			//
			$table->timestamps ();
			$table->softDeletes ();
			//
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table ( 'resources', function (Blueprint $table) {
		} );
		Schema::dropIfExists ( 'resources' );
	}
}
