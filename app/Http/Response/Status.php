<?php

namespace App\Http\Response;

use App\Http\Response\Status\Informational;
use App\Http\Response\Status\Successful;
use App\Http\Response\Status\Redirection;
use App\Http\Response\Status\ClientError;
use App\Http\Response\Status\ServerError;

class Status implements Informational, Successful, Redirection, ClientError, ServerError {
}