<?php

namespace TenantCloud\Snappt\Exceptions;

use Exception;

class SnapptDocumentUploadException extends Exception
{
	/**
	 * @param list<string> $failedChecks
	 */
	public function __construct(
		private readonly string $snapptFilename,
		private readonly array $failedChecks,
		string $message,
	) {
		parent::__construct($message);
	}

	public function getSnapptFilename(): string
	{
		return $this->snapptFilename;
	}

	/**
	 * @return list<string>
	 */
	public function getFailedChecks(): array
	{
		return $this->failedChecks;
	}
}
