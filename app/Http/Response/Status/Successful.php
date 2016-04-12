<?php

namespace App\Http\Response\Status;

interface Successful {
	const OK = 200;
	const Created = 201;
	const Accepted = 202;
	const NonAuthoritativeInformation = 203;
	const NoContent = 204;
	const ResetContent = 205;
	const PartialContent = 206;
	const MultiStatusWebDAV = 207;
	const AlreadyReportedWebDAV = 208;
	const IMUsed = 226;
}