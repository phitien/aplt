<?php

namespace App\IM\Traits;

trait AllTrait
{
	use MailerTrait;
	/**
	 *
	 * @param array $arguments        	
	 * @param string $action        	
	 * @return Response
	 */
	protected function process($action, array $arguments) {
		$action = ucfirst ( $action );
		$method = "pget{$action}";
		if (request ()->isMethod ( 'post' )) {
			$method = "ppost{$action}";
		} else if (request ()->isMethod ( 'put' )) {
			$method = "pput{$action}";
		} else if (request ()->isMethod ( 'delete' )) {
			$method = "pdelete{$action}";
		}
		return call_user_func_array ( array (
				$this,
				$method 
		), $arguments );
	}
}
