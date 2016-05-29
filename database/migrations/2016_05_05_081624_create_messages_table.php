<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateMessagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'messages', function (Blueprint $table) {
			$table->increments ( 'id' );
			//
			$table->integer ( 'parent_id' )->unsigned ()->nullable (); // item_id
			$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'items' )->onDelete ( 'cascade' );
			//
			$table->integer ( 'to_id' )->unsigned ();
			$table->integer ( 'from_id' )->unsigned ();
			$table->string ( 'content' );
			$table->boolean ( 'show_on_to' )->default ( true );
			$table->boolean ( 'show_on_from' )->default ( true );
			$table->enum ( 'status', [ 
					'SENT',
					'RECEIVED',
					'READ' 
			] )->default ( 'SENT' );
			$table->text ( 'options' )->nullable ();
			$table->timestamps ();
			$table->softDeletes ();
			//
			$table->index ( [ 
					'parent_id',
					'to_id',
					'from_id' 
			], 'message_search_index' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'messages' );
	}
}
