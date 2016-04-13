<?php

namespace App\IM\Response;

interface IResponse {
	public function jsonResponse($message = null, $data = null, $status = Status::OK, array $headers = [], $options = 0);
}