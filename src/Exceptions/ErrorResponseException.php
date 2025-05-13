<?php

namespace TenantCloud\Snappt\Exceptions;

use RuntimeException;
use Throwable;

class ErrorResponseException extends RuntimeException
{
	public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
