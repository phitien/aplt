<?php

namespace App\IM\Response\Status;

interface ServerError {
	const InternalServerError = 500;
	const NotImplemented = 501;
	const BadGateway = 502;
	const ServiceUnavailable = 503;
	const GatewayTimeout = 504;
	const HTTPVersionNotSupported = 505;
	const VariantAlsoNegotiates = 506;
	const InsufficientStorageWebDAV = 507;
	const LoopDetectedWebDAV = 508;
	const BandwidthLimitExceededApache = 509;
	const NotExtended = 510;
	const NetworkAuthenticationRequired = 511;
	const NetworkReadTimeoutError = 598;
	const NetworkConnectTimeoutError = 599;
}