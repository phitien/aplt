<?php
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// $this->call ( UsersTableSeeder::class );
		DB::table ( 'users' )->delete ();
		$users = array (
				[ 
						'name' => 'Phi Tien',
						'email' => 'phitien@gmail.com',
						'password' => Hash::make ( 'secret' ) 
				],
				[ 
						'name' => 'Phi Tien 2',
						'email' => 'phitien2@gmail.com',
						'password' => Hash::make ( 'secret' ) 
				],
				[ 
						'name' => 'Phi Tien 3',
						'email' => 'phitien3@gmail.com',
						'password' => Hash::make ( 'secret' ) 
				],
				[ 
						'name' => 'Phi Tien 4',
						'email' => 'phitien4@gmail.com',
						'password' => Hash::make ( 'secret' ) 
				] 
		);
		
		// Loop through each user above and create the record for them in the database
		foreach ( $users as $user ) {
			User::create ( $user );
		}
		
		Model::reguard ();
	}
}
