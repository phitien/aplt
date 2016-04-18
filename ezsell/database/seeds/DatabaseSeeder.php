<?php
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Ezsell\Models\Action;
use App\Ezsell\Models\Role;
use App\Ezsell\Config\Config;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard ();
		
		/**
		 * Required
		 */
		
		$roles = Config::getCoreRoles ();
		$actions = Config::getCoreActions ();
		
		// add roles
		foreach ( $roles as $code => $name ) {
			Role::create ( [ 
					'code' => $code,
					'name' => $name 
			] );
		}
		
		// add actions
		foreach ( $actions as $code => $name ) {
			Action::create ( [ 
					'code' => $code,
					'name' => $name 
			] );
		}
		
		// add relationship
		// Supreme role's actions
		foreach ( Config::getRoleCoreActions ( Role::getSupreme () ) as $code ) {
			Role::getSupreme ()->addAction ( $code );
		}
		
		// Manager role's actions
		foreach ( Config::getRoleCoreActions ( Role::getManager () ) as $code ) {
			Role::getManager ()->addAction ( $code );
		}
		
		// User role's actions
		foreach ( Config::getRoleCoreActions ( Role::getUser () ) as $code ) {
			Role::getUser ()->addAction ( $code );
		}
		
		// Guest role's actions
		foreach ( Config::getRoleCoreActions ( Role::getGuest () ) as $code ) {
			Role::getGuest ()->addAction ( $code );
		}
		
		/**
		 * Optional
		 */
		// Users
		$superadmin = User::createSuperadmin ( Config::getSuperadminData () );
		$superadmin->activate ( $superadmin->activationCode );
		$manager = User::createManager ( Config::getManagerData () );
		$manager->activate ( $manager->activationCode );
		$user = User::createUser ( Config::getUserData () );
		$user->activate ( $user->activationCode );
		
		// add followers
		$user->follow ( $superadmin );
		$user->follow ( $manager );
		
		$superadmin->accept ( $user );
		$manager->refuse ( $user );
		// $user->unfollow ( $manager );
		
		Model::reguard ();
	}
}
