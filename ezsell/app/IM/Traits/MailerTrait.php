<?php

namespace App\IM\Models\User\Traits;

use Mail;
use App\User;
use Html;
use App\IM\Utils;

trait MailerTrait
{
	/**
	 *
	 * @param User $receiver        	
	 * @param string $template        	
	 * @param string $subject        	
	 */
	public static function mailTo(User $receiver, $template, $subject, $params = [], $sendAsHtml = true) {
		Mail::send ( "IM.email.$template", $params, function ($message) use ($receiver, $subject, $sendAsHtml) {
			$message->from ( 'info@www.ezsell.com', 'EZSell' );
			$message->to ( $receiver->email, $receiver->name )->subject ( Utils::getMailSubject ( $subject ) );
			if (! $sendAsHtml) {
				// $message->setContentType ( 'text/html' );
				// $message->setBody ( Html::decode ( $message->getBody () ) );
			}
		} );
	}
}
