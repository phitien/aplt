<?php

namespace App\Http\Response\Status;

interface ClientError {
	const BadRequest = 400;
	const Unauthorized = 401;
	const PaymentRequired = 402;
	const Forbidden = 403;
	const NotFound = 404;
	const MethodNotAllowed = 405;
	const NotAcceptable = 406;
	const ProxyAuthenticationRequired = 407;
	const RequestTimeout = 408;
	const Conflict = 409;
	const Gone = 410;
	const LengthRequired = 411;
	const PreconditionFailed = 412;
	const RequestEntityTooLarge = 413;
	const RequestURITooLong = 414;
	const UnsupportedMediaType = 415;
	const RequestedRangeNotSatisfiable = 416;
	const ExpectationFailed = 417;
	const ImATeapotRFC2324 = 418;
	const EnhanceYourCalmTwitter = 420;
	const UnprocessableEntityWebDAV = 422;
	const LockedWebDAV = 423;
	const FailedDependencyWebDAV = 424;
	const ReservedForWebDAV = 425;
	const UpgradeRequired = 426;
	const PreconditionRequired = 428;
	const TooManyRequests = 429;
	const RequestHeaderFieldsTooLarge = 431;
	const NoResponseNginx = 444;
	const BlockedByWindowsParentalControlsMicrosoft = 450;
	const UnavailableForLegalReasons = 451;
	const ClientClosedRequestNginx = 499;
}