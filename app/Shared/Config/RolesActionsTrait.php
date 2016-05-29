<?php

namespace App\Shared\Config ;
 

trait RolesActionsTrait {
 	private static $__maps = [ 
		'SUPREME' => [
			'GOD_ACT', 
		],
		'MANAGER' => [
			'MANAGER_ACT', 
			'OWN_ACT', 
			'CREATE_USER', 
			'ACCESS_USER', 
			'CREATE_ROLE', 
			'ACCESS_ROLE', 
			'CREATE_ACTION', 
			'ACCESS_ACTION', 
		],
		'USER' => [
			'OWN_ACT', 
		],
		'GUEST' => [
			'GUEST_ACT', 
		],
 
	];
 }