<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Ezsell\Models\Cat;
use App\Ezsell\Models\CatDetail;
use App\Ezsell\Models\Location;
class CatsTableSeeder extends Seeder {
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
													'title' => 'Buy and Sell Womens\' Apparels, Bags, Shoes & More',
													'description' => 'Are you bored of your wardrobe? Or hoarding dresses & accessories in your closet that you no longer wear? Snap, list, and sell your preloved outfits, and declutter to make space for new ones. Browse & shop great bargains for dresses, heels, wedges, bags, accessories and more from top brands & styles.',
													'atomic' => true 
											],
											'FOR_HIM' => [ 
													'active' => true,
													'name' => 'For Him',
													'title' => 'Buy and Sell Mens\' Apparels, Bags & Accessories',
													'description' => 'Are you bored of your wardrobe? Or hoarding shoes & outfits you no longer wear? Snap, list, and sell your preloved clothes, and declutter to make space for new ones! Discover & shop great bargains for shirts, sneakers, bags, accessories and more from top brands & styles.',
													'atomic' => true 
											],
											'BABY_N_KIDS' => [ 
													'active' => true,
													'name' => 'Baby & Kids',
													'title' => 'Baby & Kids',
													'description' => 'Baby & Kids',
													'atomic' => true 
											],
											'LUXURY' => [ 
													'active' => true,
													'name' => 'Luxury',
													'title' => 'Luxury',
													'description' => 'Luxury',
													'atomic' => true 
											],
											'PET_ACCESSORIES' => [ 
													'active' => true,
													'name' => 'Pet Accessories',
													'title' => 'Pet Accessories',
													'description' => 'Pet Accessories',
													'atomic' => true 
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
													'description' => 'Furniture & Home',
													'atomic' => true 
											],
											'KITCHEN_N_APPLIANCES' => [ 
													'active' => true,
													'name' => 'Kitchen & Appliances',
													'title' => 'Kitchen & Appliances',
													'description' => 'Kitchen & Appliances',
													'atomic' => true 
											],
											'VINTAGE_N_ANTIQUES' => [ 
													'active' => true,
													'name' => 'Vintage & Antiques',
													'title' => 'Vintage & Antiques',
													'description' => 'Vintage & Antiques',
													'atomic' => true 
											],
											'BEAUTY_PRODUCTS' => [ 
													'active' => true,
													'name' => 'Beauty Products',
													'title' => 'Beauty Products',
													'description' => 'Beauty Products',
													'atomic' => true 
											],
											'TEXTBOOKS' => [ 
													'active' => true,
													'name' => 'Textbooks',
													'title' => 'Textbooks',
													'description' => 'Textbooks',
													'atomic' => true 
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
													'description' => 'Lifestyle Gadgets',
													'atomic' => true 
											],
											'DESIGN_N_CRAFT' => [ 
													'active' => true,
													'name' => 'Design & Craft',
													'title' => 'Design & Craft',
													'description' => 'Design & Craft',
													'atomic' => true 
											],
											'MUSIC_INSTRUMENTS' => [ 
													'active' => true,
													'name' => 'Music Instruments',
													'title' => 'Music Instruments',
													'description' => 'Music Instruments',
													'atomic' => true 
											],
											'PHOTOGRAPHY' => [ 
													'active' => true,
													'name' => 'Photography',
													'title' => 'Photography',
													'description' => 'Photography',
													'atomic' => true 
											],
											'SPORTING_GEAR' => [ 
													'active' => true,
													'name' => 'Sportin Gear',
													'title' => 'Sportin Gear',
													'description' => 'Sportin Gear',
													'atomic' => true 
											],
											'BOOKS' => [ 
													'active' => true,
													'name' => 'Books',
													'title' => 'Books',
													'description' => 'Books',
													'atomic' => true 
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
													'description' => 'Tickets & Vouchers',
													'atomic' => true 
											],
											'K_WAVE' => [ 
													'active' => true,
													'name' => 'K-Wave',
													'title' => 'K-Wave',
													'description' => 'K-Wave',
													'atomic' => true 
											],
											'GAMES_N_TOYS' => [ 
													'active' => true,
													'name' => 'Games & Toys',
													'title' => 'Games & Toys',
													'description' => 'Games & Toys',
													'atomic' => true 
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
													'description' => 'Preorders',
													'atomic' => true 
											],
											'EVERYTHING_ELSE' => [ 
													'active' => true,
													'name' => 'Everything Else',
													'title' => 'Everything Else',
													'description' => 'Everything Else',
													'atomic' => true 
											],
											'COMMUNITY' => [ 
													'active' => true,
													'name' => 'Community',
													'title' => 'Community',
													'description' => 'Community',
													'atomic' => true 
											],
											'LOOKING_FOR' => [ 
													'active' => true,
													'name' => 'Looking For',
													'title' => 'Looking For',
													'description' => 'Looking For',
													'atomic' => true 
											],
											'GARDENING_N_PLANTS' => [ 
													'active' => true,
													'name' => 'Gardening & Plants',
													'title' => 'Gardening & Plants',
													'description' => 'Gardening & Plants',
													'atomic' => true 
											],
											'J_POP_N_J_CULTURE' => [ 
													'active' => true,
													'name' => 'J-pop & J-culture',
													'title' => 'J-pop & J-culture',
													'description' => 'J-pop & J-culture',
													'atomic' => true 
											],
											'CARS' => [ 
													'active' => true,
													'name' => 'Cars',
													'title' => 'Cars',
													'description' => 'Cars',
													'atomic' => true 
											],
											'MOTORBIKES' => [ 
													'active' => true,
													'name' => 'Motorbikes',
													'title' => 'Motorbikes',
													'description' => 'Motorbikes',
													'atomic' => true 
											],
											'AUTO_ACCESSORIES_N_OTHERS' => [ 
													'active' => true,
													'name' => 'Auto Accessories & Others',
													'title' => 'Auto Accessories & Others',
													'description' => 'Auto Accessories & Others',
													'atomic' => true 
											],
											'HOUSING' => [ 
													'active' => true,
													'name' => 'Housing',
													'title' => 'Housing',
													'description' => 'Housing',
													'atomic' => true 
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
		Model::unguard ();
		
		$this->addCats ( $this->_cats, null, [ 
				Location::earth (),
				Location::getCountry ( 'SG' ) 
		] );
		
		Model::reguard ();
	}
	protected function addCats(array $cats = [], Cat $parent = null, array $locations = []) {
		foreach ( $cats as $code => $options ) {
			$atomic = isset ( $options ['atomic'] ) ? $options ['atomic'] : false;
			$children = isset ( $options ['children'] ) ? $options ['children'] : [ ];
			unset ( $options ['children'] );
			unset ( $options ['atomic'] );
			
			$cat = new Cat ();
			$cat->code = $code;
			$cat->active = true;
			if ($parent)
				$cat->parent ()->associate ( $parent );
			$cat->atomic = $atomic;
			$cat->save ();
			
			foreach ( $locations as $location ) {
				$catDetail = new CatDetail ( $options );
				$catDetail->parent ()->associate ( $cat );
				$catDetail->location ()->associate ( $location );
				$catDetail->save ();
			}
			
			$this->addCats ( $children, $cat, $locations );
		}
	}
}
