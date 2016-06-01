<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSubscriptionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'app' )->hasTable ( 'subscriptions' ))
			Schema::connection ( 'app' )->create ( 'subscriptions', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->integer ( 'parent_id' )->unsigned (); // item_id
				$table->enum ( 'type', [ 
						'CATEGORY',
						'ITEM',
						'USER',
						'TOPIC' 
				] );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Schema::connection ( 'app' )->dropIfExists ( 'subscriptions' );
	}
}
