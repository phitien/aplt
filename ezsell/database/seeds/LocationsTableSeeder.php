<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Ezsell\Traits\UtilTrait;
class LocationsTableSeeder extends Seeder {
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
		DB::statement ( 'DROP VIEW IF EXISTS Locations' );
		DB::statement ( "CREATE VIEW Locations AS  
				(SELECT p1.fcode,p1.countryCode,p1.name AS fullname,p1.id,p1.name,
						NULL AS parent_id,NULL AS parent_name,
						NULL AS grandparent_id,NULL AS grandparent_name,
						NULL AS great_grandparent_id,NULL AS great_grandparent_name,
						NULL AS great_great_grandparent_id,NULL AS great_great_grandparent_name,
						'$' AS currency,
						'dd MMM yyyy hh:mm' AS datetimeformat,
						'dd MMM yyyy' AS dateformat,
						'hh:mm' AS timeformat
				FROM places as p1 
				WHERE p1.level=0 AND p1.fcode='EARTH')
				UNION
				(SELECT p1.fcode,NULL AS countryCode,p1.name AS fullname,p1.id,p1.name,
						p2.id AS parent_id,p2.name AS parent_name,
						NULL AS grandparent_id,NULL AS grandparent_name,
						NULL AS great_grandparent_id,NULL AS great_grandparent_name,
						NULL AS great_great_grandparent_id,NULL AS great_great_grandparent_name,
						'$' AS currency,
						'dd MMM yyyy hh:mm' AS datetimeformat,
						'dd MMM yyyy' AS dateformat,
						'hh:mm' AS timeformat
				FROM places as p1 
				JOIN places AS p2 ON p1.parent_id=p2.id
				WHERE p1.level=1 AND p1.active=1)
				UNION
				(SELECT p1.fcode,p1.countryCode,p1.name AS fullname,p1.id,p1.name,
						p2.id AS parent_id,p2.name AS parent_name,
						p3.id AS grandparent_id,p3.name AS grandparent_name,
						NULL AS great_grandparent_id,NULL AS great_grandparent_name,
						NULL AS great_great_grandparent_id,NULL AS great_great_grandparent_name,
						'$' AS currency,
						'dd MMM yyyy hh:mm' AS datetimeformat,
						'dd MMM yyyy' AS dateformat,
						'hh:mm' AS timeformat
				FROM places as p1 
				JOIN places AS p2 ON p1.parent_id=p2.id
				JOIN places AS p3 ON p2.parent_id=p3.id
				WHERE p1.level=2 AND p1.active=1)
				UNION
				(SELECT p1.fcode,NULL AS countryCode,CONCAT_WS(', ',p1.name,p2.name) AS fullname,p1.id,p1.name,
						p2.id AS parent_id,p2.name AS parent_name,
						p3.id AS grandparent_id,p3.name AS grandparent_name,
						p4.id AS great_grandparent_id,p4.name AS great_grandparent_name,
						NULL AS great_great_grandparent_id,NULL AS great_great_grandparent_name,
						'$' AS currency,
						'dd MMM yyyy hh:mm' AS datetimeformat,
						'dd MMM yyyy' AS dateformat,
						'hh:mm' AS timeformat  
				FROM places as p1 
				JOIN places AS p2 ON p1.parent_id=p2.id
				JOIN places AS p3 ON p2.parent_id=p3.id
				JOIN places AS p4 ON p3.parent_id=p4.id
				WHERE p1.level=3 AND p1.active=1)
				UNION
				(SELECT p1.fcode,NULL AS countryCode,CONCAT_WS(', ',p1.name,p2.name,p3.name) AS fullname,p1.id,p1.name,
						p2.id AS parent_id,p2.name AS parent_name,
						p3.id AS grandparent_id,p3.name AS grandparent_name,
						p4.id AS great_grandparent_id,p4.name AS great_grandparent_name,
						p5.id AS great_great_grandparent_id,p5.name AS great_great_grandparent_name,
						'$' AS currency,
						'dd MMM yyyy hh:mm' AS datetimeformat,
						'dd MMM yyyy' AS dateformat,
						'hh:mm' AS timeformat
				FROM places as p1 
				JOIN places AS p2 ON p1.parent_id=p2.id
				JOIN places AS p3 ON p2.parent_id=p3.id
				JOIN places AS p4 ON p3.parent_id=p4.id
				JOIN places AS p5 ON p4.parent_id=p5.id
				WHERE p1.level=4 AND p1.active=1)
				ORDER BY id" );
		static::buildLocationMap ();
		Model::reguard ();
	}
}
