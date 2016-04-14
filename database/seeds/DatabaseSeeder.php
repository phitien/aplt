<?php
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\IM\Models\Action;
use App\IM\Models\Role;
use App\IM\Config;
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
		User::activateUser ( $superadmin->getActivationCode () );
		$manager = User::createManager ( Config::getManagerData () );
		User::activateUser ( $manager->getActivationCode () );
		$user = User::createUser ( Config::getUserData () );
		User::activateUser ( $user->getActivationCode () );
		
		// add followers
		$user->follow ( $superadmin );
		$user->follow ( $manager );
		
		$superadmin->acceptFollower ( $user );
		$manager->refuseFollower ( $user );
		// $user->unfollow ( $manager );
		
		Model::reguard ();
	}
}
