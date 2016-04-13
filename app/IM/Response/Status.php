<?php

namespace App\IM\Response;

use App\IM\Response\Status\Informational;
use App\IM\Response\Status\Successful;
use App\IM\Response\Status\Redirection;
use App\IM\Response\Status\ClientError;
use App\IM\Response\Status\ServerError;

class Status implements Informational, Successful, Redirection, ClientError, ServerError {
}