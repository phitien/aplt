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
		Model::unguard ();
		// $this->call ( UsersTableSeeder::class );
		DB::table ( 'users' )->delete ();
		$users = array (
				[ 
						'name' => 'Phi Tien',
						'email' => 'im.phitien@gmail.com',
						'password' => Hash::make ( 'phitien0' ) 
				],
				[ 
						'name' => 'Phi Tien 2',
						'email' => 'im.phitien2@gmail.com',
						'password' => Hash::make ( 'phitien2' ) 
				],
				[ 
						'name' => 'Phi Tien 3',
						'email' => 'im.phitien3@gmail.com',
						'password' => Hash::make ( 'phitien3' ) 
				],
				[ 
						'name' => 'Phi Tien 4',
						'email' => 'im.phitien4@gmail.com',
						'password' => Hash::make ( 'phitien4' ) 
				] 
		);
		
		// Loop through each user above and create the record for them in the database
		foreach ( $users as $user ) {
			User::create ( $user );
		}
		
		Model::reguard ();
	}
}
