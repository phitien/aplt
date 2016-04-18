<?php

namespace App\Ezsell\Traits;

use Mail;
use App\User;
use Html;
use App\Ezsell\Config\Config;

trait MailerTrait
{
	/**
	 *
	 * @param User $receiver        	
	 * @param string $template        	
	 * @param string $subject        	
	 */
	protected function mailTo(User $receiver, $template, $subject, $params = [], $sendAsHtml = true) {
		Mail::send ( "IM.email.$template", $params, function ($message) use ($receiver, $subject, $sendAsHtml) {
			$message->from ( 'info@www.ezsell.com', 'EZSell' );
			$message->to ( $receiver->email, $receiver->name )->subject ( $this->getMailSubject ( $subject ) );
			if (! $sendAsHtml) {
				// $message->setContentType ( 'text/html' );
				// $message->setBody ( Html::decode ( $message->getBody () ) );
			}
		} );
	}
	/**
	 *
	 * @param string $subject        	
	 * @return string
	 */
	protected function getMailSubject($subject) {
		return Config::MAIL_SUBJECT_PREFIX . $subject;
	}
}
