<?php

namespace App\Platform\Traits;

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
