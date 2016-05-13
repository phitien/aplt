<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Media\Traits\UtilTrait;
class ResourcesTableSeeder extends Seeder {
	/**
	 * TRAITS
	 */
	use UtilTrait;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard ();
		Model::reguard ();
	}
}
