<?php

namespace App\IM\Response\Status;

interface Informational {
	const Continuous = 100;
	const SwitchingProtocols = 101;
	const ProcessingWebDAV = 102;
}