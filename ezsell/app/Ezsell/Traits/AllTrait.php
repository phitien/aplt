<?php

namespace App\Ezsell\Traits;

trait AllTrait {
	use ApiCallRestfulTrait, 
		LocationTrait, 
		MailerTrait, 
		RequestTimeTrait, 
		ResponseTrait, 
		RestfulTrait, 
		SessionTrait, 
		TokenTrait, 
		ModeTrait,
		UtilTrait;
}
