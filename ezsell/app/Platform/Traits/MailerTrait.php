<?php

namespace App\Platform\Traits;

use Mail;
use App\User;
use Html;
use App\Platform\Config;

trait MailerTrait {
	/**
	 *
	 * @param User $receiver        	
	 * @param string $template        	
	 * @param string $subject        	
	 */
	protected function mailTo(User $receiver, $template, $subject, $params = [], $sendAsHtml = true) {
		Mail::send ( "IM.email.$template", $params, function ($message) use ($receiver, $subject, $sendAsHtml) {
			$message->from ( trans ( 'messages.email.from' ), trans ( 'messages.email.name' ) );
			$message->to ( $receiver->email, $receiver->name )->subject ( $this->getMailSubject ( $subject ) );
			if (! $sendAsHtml) {
				// $message->setContentType ( 'text/html' );
				// $message->setBody ( Html::decode ( $message->getBody () ) );
			}
		} );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected function sendActivationEmail(User $user) {
		$this->mailTo ( $user, 'register', trans ( 'messages.sentences.register_email_subject' ), [ 
				'title' => trans ( 'messages.sentences.register_email_title' ),
				'receiver' => $user,
				'url' => static::getBaseUri () . '/api/activate/' . $user->generateActivationCode () 
		] );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected function resendActivationEmail(User $user) {
		$this->mailTo ( $user, 'register', trans ( 'messages.sentences.code_sending_email_subject' ), [ 
				'title' => trans ( 'messages.sentences.code_sending_email_title' ),
				'receiver' => $user,
				'url' => static::getBaseUri () . '/api/activate/' . $user->generateActivationCode () 
		] );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected function sendEmailChangedEmail(User $user, $newEmail) {
		$this->mailTo ( $user, 'register', trans ( 'messages.sentences.email_changing_email_subject' ), [ 
				'title' => trans ( 'messages.sentences.email_changing_email_subject' ),
				'receiver' => $user,
				'email' => $newEmail 
		] );
	}
	/**
	 *
	 * @param string $subject        	
	 * @return string
	 */
	protected function getMailSubject($subject) {
		return trans ( 'messages.sentences.' . Config::MAIL_SUBJECT_PREFIX ) . $subject;
	}
}
