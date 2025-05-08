<?php

namespace TenantCloud\Snappt\Exceptions;

use Exception;
use Throwable;

class ErrorResponseException extends Exception
{
	public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
