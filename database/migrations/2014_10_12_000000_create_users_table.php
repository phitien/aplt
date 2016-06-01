<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'im' )->hasTable ( 'users' ))
			Schema::connection ( 'im' )->create ( 'users', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->string ( 'name' )->unique ();
				$table->string ( 'email' )->unique ();
				$table->string ( 'password' );
				$table->boolean ( 'active' )->nullable ();
				$table->text ( 'activationCode' )->nullable ();
				$table->string ( 'second_email' )->unique ()->nullable ();
				$table->string ( 'first_name' )->nullable ();
				$table->string ( 'last_name' )->nullable ();
				$table->string ( 'middle_name' )->nullable ();
				$table->string ( 'alias' )->nullable ();
				$table->date ( 'birthday' )->nullable ();
				$table->enum ( 'gender', [ 
						'FEMALE',
						'MALE' 
				] )->default ( 'MALE' )->nullable ();
				$table->enum ( 'marital_status', [ 
						'SINGLE',
						'MARRIED',
						'DIVORCED',
						'SEPARATED' 
				] )->nullable ();
				$table->string ( 'mobile' )->unique ()->nullable ();
				$table->string ( 'country' )->nullable ();
				$table->string ( 'state' )->nullable ();
				$table->string ( 'city' )->nullable ();
				$table->string ( 'address' )->nullable ();
				$table->string ( 'postcode' )->nullable ();
				$table->string ( 'avatar' )->nullable ();
				$table->string ( 'cover' )->nullable ();
				$table->text ( 'status' )->nullable ();
				$table->text ( 'quote' )->nullable ();
				$table->text ( 'description' )->nullable ();
				$table->string ( 'baseUrl' )->nullable ();
				$table->text ( 'json' )->nullable ();
				$table->rememberToken ();
				$table->timestamps ();
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
// 		if (Schema::connection ( 'im' )->hasTable ( 'users' ))
// 			Schema::connection ( 'im' )->dropIfExists ( 'users' );
	}
}
