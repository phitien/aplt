<?php

namespace App\Http\Response\Status;

interface Redirection {
	const MultipleChoices = 300;
	const MovedPermanently = 301;
	const AccFoundepted = 302;
	const SeeOther = 303;
	const NotModified = 304;
	const UseProxy = 305;
	const Unused = 306;
	const TemporaryRedirect = 307;
	const PermanentRedirect = 308;
}