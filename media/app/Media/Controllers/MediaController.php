<?php

namespace App\Media\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Media\Models\Resource;
use File;
use Image;

class MediaController extends Controller {
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
		return $this->process ( 'media', func_get_args () );
	}
	protected function pgetMedia(Request $request, $code) {
		$resource = Resource::where ( 'code', $code )->first ();
		if ($resource) {
			$this->pumpImagePath ( $resource->path );
		} else {
			$this->pumpNoImage ();
		}
	}
	protected function ppostMedia(Request $request) {
		$file = $request->file ( 'image' );
		if ($file->isValid ()) {
			if ($code = $this->saveImage ( $request, $file )) {
				return $this->jsonResponse ( 'uploaded', $this->buildImagePath ( $code ) );
			} else {
				return $this->jsonResponse ( 'upload_failed', null, Response::HTTP_BAD_REQUEST );
			}
		} else {
			return $this->jsonResponse ( 'upload_failed', null, Response::HTTP_BAD_REQUEST );
		}
	}
	protected function buildImagePath($code) {
		return static::getBaseUri () . "/media/{$code}";
	}
	/**
	 */
	protected function saveImage(Request $request, $file) {
		if ($file && substr ( $file->getMimeType (), 0, 5 ) == 'image') {
			$domain = $this->param ( 'DOMAIN' );
			$user = $this->getUser ();
			if ($domain && $user && $user->id) {
				$folder = "../repo/{$domain}/{$user->id}";
				if (! File::exists ( $folder )) {
					File::makeDirectory ( $folder, 755, true, true );
				}
				$filename = uniqid ( 'media' );
				$path = "{$folder}/{$filename}";
				$image = Image::make ( $file )->save ( $path );
				$resource = Resource::create ( [ 
						'user_id' => $user->id,
						'domain' => $domain,
						'code' => $filename,
						'path' => $path 
				] );
				if ($resource->save ())
					return $filename;
			}
		}
		return false;
	}
}
