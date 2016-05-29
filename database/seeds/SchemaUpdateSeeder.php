<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
class SchemaUpdateSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard ();
		
		$this->createMessagesTable ();
		Model::reguard ();
	}
	protected function createMessagesTable() {
		Schema::dropIfExists ( 'groups' );
		Schema::dropIfExists ( 'topics' );
		Schema::create ( 'topics', function (Blueprint $table) {
			$table->increments ( 'id' );
			//
			$table->integer ( 'location_id' )->unsigned ();
			//
			$table->boolean ( 'active' )->nullable ()->default ( 0 );
			//
			$table->string ( 'title' )->unique ();
			$table->text ( 'description' )->nullable ();
			$table->text ( 'avatar' )->nullable ();
			$table->text ( 'cover' )->nullable ();
			//
			$table->text ( 'tags' )->nullable ();
			$table->text ( 'options' )->nullable ();
			//
			$table->integer ( 'bits' )->nullable ()->default ( 0 );
			//
			$table->timestamps ();
			$table->softDeletes ();
			//
			$table->index ( [ 
					'location_id',
					'title' 
			], 'topic_search_index' );
		} );
	}
}
