<?php

namespace App\Media\Controllers;

use Illuminate\Http\Request;
use Image;

class MediaController extends BaseController {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'media' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ ] 
	];
	public function media(Request $request) {
		$this->process ( 'media', func_get_args () );
	}
	public function getMedia(Request $request, $code) {
		$this->pumpImage ( Image::make ( '../repo/images/not-found.jpg' ) );
	}
}
