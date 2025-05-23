<?php

namespace TenantCloud\Snappt\Exceptions;

use RuntimeException;
use Throwable;

class ErrorResponseException extends RuntimeException
{
	public function __construct(string $url, string $errorMessage, int $code = 0, ?Throwable $previous = null)
	{
		$message = sprintf('Received error response from API "%s". %s', $url, $errorMessage);

		parent::__construct($message, $code, $previous);
	}
}
