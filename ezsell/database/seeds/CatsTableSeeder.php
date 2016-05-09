<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Ezsell\Models\Cat;
use App\Ezsell\Models\CatDetail;
use App\Ezsell\Models\Location;
class CatsTableSeeder extends Seeder {
	/**
	 * Default location
	 *
	 * @var Place
	 */
	protected $_default_location;
	/**
	 *
	 * @var array
	 */
	protected $_cats = [ 
			'ROOT' => [ 
					'active' => true,
					'name' => 'Categories',
					'title' => 'Categories',
					'description' => 'Categories',
					'children' => [ 
							'CLOTHING_N_ACCESSORIES' => [ 
									'active' => true,
									'name' => 'Clothing & Accessories',
									'title' => 'Clothing & Accessories',
									'description' => 'Clothing & Accessories',
									'children' => [ 
											'FOR_HER' => [ 
													'active' => true,
													'name' => 'For Her',
													'title' => 'For Her',
													'description' => 'For Her' 
											],
											'FOR_HIM' => [ 
													'active' => true,
													'name' => 'For Him',
													'title' => 'For Him',
													'description' => 'For Him' 
											],
											'BABY_N_KIDS' => [ 
													'active' => true,
													'name' => 'Baby & Kids',
													'title' => 'Baby & Kids',
													'description' => 'Baby & Kids' 
											],
											'LUXURY' => [ 
													'active' => true,
													'name' => 'Luxury',
													'title' => 'Luxury',
													'description' => 'Luxury' 
											],
											'PET_ACCESSORIES' => [ 
													'active' => true,
													'name' => 'Pet Accessories',
													'title' => 'Pet Accessories',
													'description' => 'Pet Accessories' 
											] 
									] 
							],
							'HOME_N_LIFESTYLE' => [ 
									'active' => true,
									'name' => 'Home & Lifestyle',
									'title' => 'Home & Lifestyle',
									'description' => 'Home & Lifestyle',
									'children' => [ 
											'FURNITURE_N_HOME' => [ 
													'active' => true,
													'name' => 'Furniture & Home',
													'title' => 'Furniture & Home',
													'description' => 'Furniture & Home' 
											],
											'KITCHEN_N_APPLIANCES' => [ 
													'active' => true,
													'name' => 'Kitchen & Appliances',
													'title' => 'Kitchen & Appliances',
													'description' => 'Kitchen & Appliances' 
											],
											'VINTAGE_N_ANTIQUES' => [ 
													'active' => true,
													'name' => 'Vintage & Antiques',
													'title' => 'Vintage & Antiques',
													'description' => 'Vintage & Antiques' 
											],
											'BEAUTY_PRODUCTS' => [ 
													'active' => true,
													'name' => 'Beauty Products',
													'title' => 'Beauty Products',
													'description' => 'Beauty Products' 
											],
											'TEXTBOOKS' => [ 
													'active' => true,
													'name' => 'Textbooks',
													'title' => 'Textbooks',
													'description' => 'Textbooks' 
											] 
									] 
							],
							'HOBBIES_N_GADGETS' => [ 
									'active' => true,
									'name' => 'Hobbies & Gadgets',
									'title' => 'Hobbies & Gadgets',
									'description' => 'Hobbies & Gadgets',
									'children' => [ 
											'LIFESTYLE_GADGETS' => [ 
													'active' => true,
													'name' => 'Lifestyle Gadgets',
													'title' => 'Lifestyle Gadgets',
													'description' => 'Lifestyle Gadgets' 
											],
											'DESIGN_N_CRAFT' => [ 
													'active' => true,
													'name' => 'Design & Craft',
													'title' => 'Design & Craft',
													'description' => 'Design & Craft' 
											],
											'MUSIC_INSTRUMENTS' => [ 
													'active' => true,
													'name' => 'Music Instruments',
													'title' => 'Music Instruments',
													'description' => 'Music Instruments' 
											],
											'PHOTOGRAPHY' => [ 
													'active' => true,
													'name' => 'Photography',
													'title' => 'Photography',
													'description' => 'Photography' 
											],
											'SPORTING_GEAR' => [ 
													'active' => true,
													'name' => 'Sportin Gear',
													'title' => 'Sportin Gear',
													'description' => 'Sportin Gear' 
											],
											'BOOKS' => [ 
													'active' => true,
													'name' => 'Books',
													'title' => 'Books',
													'description' => 'Books' 
											] 
									] 
							],
							'ENTERTAINMENT' => [ 
									'active' => true,
									'name' => 'Entertainment',
									'title' => 'Entertainment',
									'description' => 'Entertainment',
									'children' => [ 
											'TICKETS_N_VOUCHERS' => [ 
													'active' => true,
													'name' => 'Tickets & Vouchers',
													'title' => 'Tickets & Vouchers',
													'description' => 'Tickets & Vouchers' 
											],
											'K_WAVE' => [ 
													'active' => true,
													'name' => 'K-Wave',
													'title' => 'K-Wave',
													'description' => 'K-Wave' 
											],
											'GAMES_N_TOYS' => [ 
													'active' => true,
													'name' => 'Games & Toys',
													'title' => 'Games & Toys',
													'description' => 'Games & Toys' 
											] 
									] 
							],
							'OTHER' => [ 
									'active' => true,
									'name' => 'Other',
									'title' => 'Other',
									'description' => 'Other',
									'children' => [ 
											'PREORDERS' => [ 
													'active' => true,
													'name' => 'Preorders',
													'title' => 'Preorders',
													'description' => 'Preorders' 
											],
											'EVERYTHING_ELSE' => [ 
													'active' => true,
													'name' => 'Everything Else',
													'title' => 'Everything Else',
													'description' => 'Everything Else' 
											],
											'COMMUNITY' => [ 
													'active' => true,
													'name' => 'Community',
													'title' => 'Community',
													'description' => 'Community' 
											],
											'LOOKING_FOR' => [ 
													'active' => true,
													'name' => 'Looking For',
													'title' => 'Looking For',
													'description' => 'Looking For' 
											],
											'GARDENING_N_PLANTS' => [ 
													'active' => true,
													'name' => 'Gardening & Plants',
													'title' => 'Gardening & Plants',
													'description' => 'Gardening & Plants' 
											],
											'J_POP_N_J_CULTURE' => [ 
													'active' => true,
													'name' => 'J-pop & J-culture',
													'title' => 'J-pop & J-culture',
													'description' => 'J-pop & J-culture' 
											],
											'CARS' => [ 
													'active' => true,
													'name' => 'Cars',
													'title' => 'Cars',
													'description' => 'Cars' 
											],
											'MOTORBIKES' => [ 
													'active' => true,
													'name' => 'Motorbikes',
													'title' => 'Motorbikes',
													'description' => 'Motorbikes' 
											],
											'AUTO_ACCESSORIES_N_OTHERS' => [ 
													'active' => true,
													'name' => 'Auto Accessories & Others',
													'title' => 'Auto Accessories & Others',
													'description' => 'Auto Accessories & Others' 
											],
											'HOUSING' => [ 
													'active' => true,
													'name' => 'Housing',
													'title' => 'Housing',
													'description' => 'Housing' 
											] 
									] 
							] 
					] 
			] 
	];
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->_default_location = Location::getCountry ( 'SG' );
		Model::unguard ();
		$this->addCats ( $this->_cats );
		Model::reguard ();
	}
	protected function addCats(array $cats = [], Cat $parent = null) {
		foreach ( $cats as $code => $options ) {
			$cat = new Cat ();
			$cat->code = $code;
			$cat->active = true;
			if ($parent)
				$cat->parent ()->associate ( $parent );
			$cat->save ();
			$children = isset ( $options ['children'] ) ? $options ['children'] : [ ];
			unset ( $options ['children'] );
			$catDetail = new CatDetail ( $options );
			$catDetail->parent ()->associate ( $cat );
			$catDetail->location ()->associate ( $this->_default_location );
			$catDetail->save ();
			$this->addCats ( $children, $cat );
		}
	}
}
