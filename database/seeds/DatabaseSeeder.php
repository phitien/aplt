<?php
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Helper\Table;
use App\IM\Models\Action;
use App\IM\Models\Role;
use App\IM\Models\Group;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard ();
		
		DB::table ( 'users' )->delete ();
		$users = array (
				[ 
						'name' => 'superadmin',
						'email' => 'superadmin@gmail.com',
						'password' => Hash::make ( 'superadmin' ) 
				],
				[ 
						'name' => 'admin',
						'email' => 'admin@gmail.com',
						'password' => Hash::make ( 'admin1' ) 
				],
				[ 
						'name' => 'manager',
						'email' => 'manager@gmail.com',
						'password' => Hash::make ( 'manager' ) 
				],
				[ 
						'name' => 'user',
						'email' => 'user@gmail.com',
						'password' => Hash::make ( 'user12' ) 
				] 
		);
		
		// Loop through each user above and create the record for them in the database
		foreach ( $users as $user ) {
			User::create ( $user );
		}
		
		// add followers
		DB::table ( 'user_follower' )->delete ();
		$user = User::find ( 1 );
		$user->followers ()->save ( User::find ( 2 ) );
		$user->followers ()->saveMany ( [ 
				User::find ( 3 ),
				User::find ( 4 ) 
		] );
		
		// add actions
		DB::table ( 'actions' )->delete ();
		$actions = [ 
				[ 
						'code' => 'ALL',
						'name' => 'All' 
				],
				[ 
						'code' => 'CREATE',
						'name' => 'Create' 
				],
				[ 
						'code' => 'UPDATE',
						'name' => 'Update' 
				],
				[ 
						'code' => 'DELETE',
						'name' => 'Delete' 
				],
				[ 
						'code' => 'VIEW_LIST',
						'name' => 'View List' 
				],
				[ 
						'code' => 'VIEW_DETAIL',
						'name' => 'View Detail' 
				],
				[ 
						'code' => 'CREATE_USER',
						'name' => 'Create User' 
				],
				[ 
						'code' => 'UPDATE_USER',
						'name' => 'Update User' 
				],
				[ 
						'code' => 'DELETE_USER',
						'name' => 'Delete User' 
				],
				[ 
						'code' => 'VIEW_USER_DETAIL',
						'name' => 'View User Detail' 
				],
				[ 
						'code' => 'VIEW_USER_LIST',
						'name' => 'View User LIST' 
				],
				[ 
						'code' => 'CREATE_GROUP',
						'name' => 'Create Group' 
				],
				[ 
						'code' => 'UPDATE_GROUP',
						'name' => 'Update Group' 
				],
				[ 
						'code' => 'DELETE_GROUP',
						'name' => 'Delete Group' 
				],
				[ 
						'code' => 'VIEW_GROUP_DETAIL',
						'name' => 'View Group Detail' 
				],
				[ 
						'code' => 'VIEW_GROUP_LIST',
						'name' => 'View Group LIST' 
				],
				[ 
						'code' => 'CREATE_ROLE',
						'name' => 'Create Role' 
				],
				[ 
						'code' => 'UPDATE_ROLE',
						'name' => 'Update Role' 
				],
				[ 
						'code' => 'DELETE_ROLE',
						'name' => 'Delete Role' 
				],
				[ 
						'code' => 'VIEW_ROLE_DETAIL',
						'name' => 'View Role Detail' 
				],
				[ 
						'code' => 'VIEW_ROLE_LIST',
						'name' => 'View Role LIST' 
				],
				[ 
						'code' => 'CREATE_ACTION',
						'name' => 'Create Action' 
				],
				[ 
						'code' => 'UPDATE_ACTION',
						'name' => 'Update Action' 
				],
				[ 
						'code' => 'DELETE_ACTION',
						'name' => 'Delete Action' 
				],
				[ 
						'code' => 'VIEW_ACTION_DETAIL',
						'name' => 'View Action Detail' 
				],
				[ 
						'code' => 'VIEW_ACTION_LIST',
						'name' => 'View Action LIST' 
				] 
		];
		foreach ( $actions as $action ) {
			Action::create ( $action );
		}
		
		// add roles
		DB::table ( 'roles' )->delete ();
		$roles = [ 
				[ 
						'code' => 'SUPREME',
						'name' => 'Supreme' 
				],
				[ 
						'code' => 'USER_SUPREME',
						'name' => 'User supreme' 
				],
				[ 
						'code' => 'GROUP_SUPREME',
						'name' => 'Group supreme' 
				],
				[ 
						'code' => 'ROLE_SUPREME',
						'name' => 'Role supreme' 
				],
				[ 
						'code' => 'ACTION_SUPREME',
						'name' => 'Action supreme' 
				] 
		];
		foreach ( $roles as $role ) {
			Role::create ( $role );
		}
		
		// add groups
		DB::table ( 'groups' )->delete ();
		$groups = [ 
				[ 
						'name' => 'Supper Admin',
						'description' => 'Supper Admin',
						'active' => 1 
				],
				[ 
						'name' => 'Manager',
						'description' => 'Manager',
						'active' => 1 
				],
				[ 
						'name' => 'User',
						'description' => 'User',
						'active' => 1 
				] 
		];
		foreach ( $groups as $group ) {
			Group::create ( $group );
		}
		
		// add relationship
		// role_action:Supreme
		User::find ( 1 )->groups ()->save ( Group::find ( 1 ) );
		User::find ( 1 )->roles ()->save ( Role::find ( 1 ) );
		User::find ( 1 )->actions ()->save ( Action::find ( 1 ) );
		
		Group::find ( 1 )->roles ()->save ( Role::find ( 1 ) );
		Group::find ( 1 )->actions ()->save ( Action::find ( 1 ) );
		
		Role::find ( 1 )->actions ()->save ( Action::find ( 1 ) );
		
		// User
		Role::find ( 2 )->actions ()->save ( Action::find ( 2 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 3 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 4 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 5 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 6 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 7 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 8 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 9 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 10 ) );
		Role::find ( 2 )->actions ()->save ( Action::find ( 11 ) );
		// role_action:Group
		Role::find ( 3 )->actions ()->save ( Action::find ( 2 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 3 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 4 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 5 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 6 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 12 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 13 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 14 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 15 ) );
		Role::find ( 3 )->actions ()->save ( Action::find ( 16 ) );
		// role_action:Role
		Role::find ( 4 )->actions ()->save ( Action::find ( 2 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 3 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 4 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 5 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 6 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 17 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 18 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 19 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 20 ) );
		Role::find ( 4 )->actions ()->save ( Action::find ( 21 ) );
		// role_action:Action
		Role::find ( 5 )->actions ()->save ( Action::find ( 2 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 3 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 4 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 5 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 6 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 22 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 23 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 24 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 25 ) );
		Role::find ( 5 )->actions ()->save ( Action::find ( 26 ) );
		
		Model::reguard ();
	}
}
