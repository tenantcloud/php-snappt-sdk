<?php

namespace TenantCloud\Snappt\Exceptions;

use Exception;

class SnapptDocumentUploadException extends Exception
{
	public function __construct(
		private readonly string $snapptFilename,
		string $message
	) {
		parent::__construct($message);
	}

	public function getSnapptFilename(): string
	{
		return $this->snapptFilename;
	}
}
