<?php

namespace App\Platform\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait SocietyTrait {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function followers(Request $request) { // TODO
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function following(Request $request) { // TODO
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function follow(Request $request) {
		return $this->process ( 'follow', func_get_args () );
	}
	protected function pajaxFollow(Request $request, $id) {
		$response = static::apiCallFollow ( $id );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->jsonResponse ( 'followed', static::getUser () );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->jsonResponse ( trans ( 'messages.sentences.follow_failed', [ 
					'reason' => trans ( "messages.errors.{$data ['message']}" ) 
			] ), null, $response->getStatusCode () );
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function unfollow(Request $request, $id) {
		return $this->process ( 'unfollow', func_get_args () );
	}
	protected function pajaxUnfollow(Request $request, $id) {
		$response = static::apiCallUnfollow ( $id );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->jsonResponse ( 'unfollowed', static::getUser () );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->jsonResponse ( trans ( 'messages.sentences.unfollow_failed', [ 
					'reason' => trans ( "messages.errors.{$data ['message']}" ) 
			] ), null, $response->getStatusCode () );
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function accept(Request $request, $id) { // TODO
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function refuse(Request $request, $id) { // TODO
	}
}
