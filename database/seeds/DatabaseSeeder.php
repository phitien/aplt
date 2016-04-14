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
		foreach ( $roles as $role ) {
			Role::create ( $role );
		}
		
		// add actions
		foreach ( $actions as $action ) {
			Action::create ( $action );
		}
		
		// add relationship
		// Supreme role's actions
		$supremeRole = Role::find ( 1 );
		foreach ( Config::getRoleActions ( $supremeRole ) as $action ) {
			$supremeRole->addAction ( $code = $actions [$action] ['code'] );
		}
		
		// Manager role's actions
		$managerRole = Role::find ( 2 );
		foreach ( Config::getRoleActions ( $managerRole ) as $action ) {
			$managerRole->addAction ( $code = $actions [$action] ['code'] );
		}
		
		// User role's actions
		$userRole = Role::find ( 3 );
		foreach ( Config::getRoleActions ( $userRole ) as $action ) {
			$userRole->addAction ( $code = $actions [$action] ['code'] );
		}
		
		// Guest role's actions
		$guestRole = Role::find ( 4 );
		foreach ( Config::getRoleActions ( $guestRole ) as $action ) {
			$guestRole->addAction ( $code = $actions [$action] ['code'] );
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
// 		$user->unfollow ( $manager );
		
		Model::reguard ();
	}
}
